<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait CommonHelperTrait
{

    public function UploadImageCreate($image, $path)
    {
        if ($image && is_file($image)) {

            $extension = $image->guessExtension();
            $filename  = time() . '.' . $extension;

            $image_record       = new Image();
            if (setting('file_system') == 's3') {
                $filePath       = s3Upload($path, $image);
                $imagePostSuccess = Storage::disk('s3')->exists($filePath);
                $image_record->path = $filePath;
            } else {
                $image->move($path, $filename);
                $image_record->path = $path . '/' . $filename;
            }
            $image_record->save();

            return $image_record->id;
        }
        return null;
    }

    public function UploadImageUpdate($image, $path, $image_id)
    {
        if ($image && is_file($image)) {

            if ($image_id) {
                $image_record = Image::find($image_id);
                if (setting('file_system') == 's3') {
                    Storage::disk('s3')->delete($image_record->path);
                } else {
                    $file_path    = public_path($image_record->path);
                    if (file_exists($file_path)) {
                        File::delete($file_path);
                    }
                }
            } else {
                $image_record = new Image();
            }

            $extension          = $image->guessExtension();
            $filename           = time() . '.' . $extension;
            if (setting('file_system') == 's3') {
                $filePath       = s3Upload($path, $image);
                $image_record->path = $filePath;
            } else {
                $image->move($path, $filename);
                $image_record->path = $path . '/' . $filename;
            }

            $image_record->save();
            return $image_record->id;
        }
        return $image_id;
    }

    public function UploadImageDelete($image_id)
    {
        if ($image_id) {
            $image_record = Image::find($image_id);
            $file_path    = public_path($image_record->path);
            if (file_exists($file_path)) {
                File::delete($file_path);
            }
            $image_record->delete();
        }
        return true;
    }

    public function setEnvironmentValue($envKey, $envValue)
    {
        return $this->putEnvConfigration($envKey, $envValue);

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
    
        $str .= "\n"; // In case the searched variable is in the last line without \n
        $keyPosition = strpos($str, "{$envKey}=");
    
        if ($keyPosition === false) {
            // If the variable doesn't exist, add it to the end of the file
            $str .= "{$envKey}={$envValue}\n";
        } else {
            $endOfLinePosition = strpos($str, PHP_EOL, $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
            $envValue = '"' . $envValue . '"';
            $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
        }
    
        $str = rtrim($str, "\n");
    
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
        
        return true;
    }
    

    function generateInvoiceNumber($prefix = null)
    {
        $prefix = $prefix ? $prefix : 'INV';
        $invoice_number = $prefix . '-' . date('Ymd') . '-' . Str::random(6);
        return $invoice_number;
    }


    function putEnvConfigration($envKey, $envValue)
    {
        $envValue = str_replace('\\', '\\' . '\\', $envValue);
        $value = '"' . $envValue . '"';
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $str .= "\n";
        $keyPosition = strpos($str, "{$envKey}=");

        if (is_bool($keyPosition)) {

            $str .= $envKey . '="' . $envValue . '"';
        } else {
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
            $str = str_replace($oldLine, "{$envKey}={$value}", $str);

            $str = substr($str, 0, -1);
        }

        if (!file_put_contents($envFile, $str)) {
            return false;
        } else {
            return true;
        }
    }
}
