<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\QrCode\QrCode;

trait QrCodeGenerator
{
    protected $barcode_array;
    protected $store_path = 'temp/';


    public function getBarcodePNGUri($code, $type, $w = 3, $h = 3, $color = array(0, 0, 0))
    {
        return url($this->getBarcodePNGPath($code, $type, $w, $h, $color));
    }    

    public function getBarcodePNGPath($code, $type, $w = 3, $h = 3, $color = array(0, 0, 0))
    {

        //set barcode code and type
        $this->setBarcode($code, $type);
        // calculate image size
        $width = ($this->barcode_array['num_cols'] * $w);
        $height = ($this->barcode_array['num_rows'] * $h);
        if (function_exists('imagecreate')) {
            // GD library
            $imagick = false;
            $png = imagecreate($width, $height);
            $bgcol = imagecolorallocate($png, 255, 255, 255);
            imagecolortransparent($png, $bgcol);
            $fgcol = imagecolorallocate($png, $color[0], $color[1], $color[2]);
        } elseif (extension_loaded('imagick')) {
            $imagick = true;
            $bgcol = new imagickpixel('rgb(255,255,255');
            $fgcol = new imagickpixel('rgb(' . $color[0] . ',' . $color[1] . ',' . $color[2] . ')');
            $png = new Imagick();
            $png->newImage($width, $height, 'none', 'png');
            $bar = new imagickdraw();
            $bar->setfillcolor($fgcol);
        } else {
            return false;
        }
        // print barcode elements
        $y = 0;
        // for each row
        for ($r = 0; $r < $this->barcode_array['num_rows']; ++$r) {
            $x = 0;
            // for each column
            for ($c = 0; $c < $this->barcode_array['num_cols']; ++$c) {
                if ($this->barcode_array['bcode'][$r][$c] == 1) {
                    // draw a single barcode cell
                    if ($imagick) {
                        $bar->rectangle($x, $y, ($x + $w), ($y + $h));
                    } else {
                        imagefilledrectangle($png, $x, $y, ($x + $w), ($y + $h), $fgcol);
                    }
                }
                $x += $w;
            }
            $y += $h;
        }
        $file_name = Str::slug($code);
        $save_file = $this->checkfile($this->store_path . $file_name . ".png");

        if ($imagick) {
            $png->drawimage($bar);
            //echo $png;
        }
        if (ImagePng($png, $save_file)) {
            imagedestroy($png);
            return str_replace(public_path(), '', $save_file);
        } else {
            imagedestroy($png);
            return $code;
        }
    }

    /**
     * Set the barcode.
     * @param $code (string) code to print
     * @param $type (string) type of barcode: <ul><li>DATAMATRIX : Datamatrix (ISO/IEC 16022)</li><li>PDF417 : PDF417 (ISO/IEC 15438:2006)</li><li>PDF417,a,e,t,s,f,o0,o1,o2,o3,o4,o5,o6 : PDF417 with parameters: a = aspect ratio (width/height); e = error correction level (0-8); t = total number of macro segments; s = macro segment index (0-99998); f = file ID; o0 = File Name (text); o1 = Segment Count (numeric); o2 = Time Stamp (numeric); o3 = Sender (text); o4 = Addressee (text); o5 = File Size (numeric); o6 = Checksum (numeric). NOTES: Parameters t, s and f are required for a Macro Control Block, all other parametrs are optional. To use a comma character ',' on text options, replace it with the character 255: "\xff".</li><li>QRCODE : QRcode Low error correction</li><li>QRCODE,L : QRcode Low error correction</li><li>QRCODE,M : QRcode Medium error correction</li><li>QRCODE,Q : QRcode Better error correction</li><li>QRCODE,H : QR-CODE Best error correction</li><li>RAW: raw mode - comma-separad list of array rows</li><li>RAW2: raw mode - array rows are surrounded by square parenthesis.</li><li>TEST : Test matrix</li></ul>
     * @return array
     */
    protected function setBarcode($code, $type)
    {
        $mode = explode(',', $type);
        $qrtype = strtoupper($mode[0]);
        if (!isset($mode[1]) or (!in_array($mode[1], array('L', 'M', 'Q', 'H')))) {
            $mode[1] = 'L'; // Ddefault: Low error correction
        }
        $barcode = new QRcode($code, strtoupper($mode[1]));
        $this->barcode_array = $barcode->getBarcodeArray();
        $this->barcode_array['code'] = $code;
    }

    /**
     *
     * @param type $path
     * @return type
     */
    protected function checkfile($path)
    {
        if(!file_exists($this->store_path)) {
            mkdir($this->store_path, 0777, true);
        }else if (file_exists($path)) {
            unlink($path);
        }
        return $path;
    }

    public function setStorPath($path)
    {
        $this->store_path = $path;
        return $this;
    }

}
