<?php

namespace Modules\Addon\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Addon\Entities\Addon;
use Modules\Addon\Interfaces\AddonInterface;
use ZipArchive;

class AddonRepository implements AddonInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(Addon $addonModel)
    {
        $this->model = $addonModel;
    }

    public function model()
    {
        return $this->model;
    }

    public function store($request)
    {
        if (env('APP_DEMO')) {
            return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
        }

        try {
            // addon_file upload
            if ($request->hasFile('addon_file')) {
                // Retrieve the uploaded file
                $uploadedFile = $request->file('addon_file');

                // Generate a unique name for the plugin directory
                $pluginDirectory = 'plugins/';

                // Create the storage directory if it doesn't exist
                if (!File::exists(storage_path($pluginDirectory))) {
                    File::makeDirectory(storage_path($pluginDirectory), 0755, true);
                }

                // Store the uploaded file in the storage directory
                $uploadedFileName = $uploadedFile->getClientOriginalName();

                $uploadedFilePath = storage_path($pluginDirectory . $uploadedFileName);
                $uploadedFile->move(storage_path($pluginDirectory), $uploadedFileName);

                // Extract the zip file
                $extractPath = base_path('Modules/' . basename($uploadedFileName, '.zip'));
                $zip = new ZipArchive;
                $zip->open($uploadedFilePath);
                $zip->extractTo($extractPath);
                $zip->close();

                // Read the module.json file
                File::delete($uploadedFilePath);
                if (File::exists($extractPath . '/' . $uploadedFileName)) {
                    File::delete($extractPath . '/' . $uploadedFileName);
                }

                $moduleJsonPath = $extractPath . '/module.json';
                $moduleJsonContents = File::get($moduleJsonPath);
                $moduleInfo = json_decode($moduleJsonContents, true);

                $destinationPath = public_path('module_images');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
                File::copy($extractPath . '/assets/' . $moduleInfo['thumbnail'], $destinationPath . '/' . $moduleInfo['thumbnail']);
                $addon = $this->model->where('title', $moduleInfo['name'])->first();
                if (!$addon) {
                    $addon = new $this->model;
                }
                // file from update folder to root folder
                $updatePath = $extractPath . '/update';
                if (File::exists($updatePath)) {
                    try {
                        // Copy the entire contents of the "update" folder to the root directory
                        File::copyDirectory($updatePath, base_path());

                        // Delete the "update" folder after copying
                        File::deleteDirectory($updatePath);

                    } catch (\Throwable $th) {
                        // Handle any exceptions that might occur during copying
                        return $this->responseWithError($th->getMessage(), [], 400);
                    }
                }
                // Save the module information to the model
                $addon->title = $moduleInfo['name'];
                $addon->thumbnail = 'module_images/' . $moduleInfo['thumbnail'];
                $addon->description = $moduleInfo['description'];
                $addon->purchase_code = @$request->purchase_code;
                $addon->is_installed = 1;
                moduleUpdate($moduleInfo['name'], true);
                Artisan::call('module:migrate', [
                    'module' => $moduleInfo['name'],
                    '--force' => true,
                ]);
                Artisan::call('module:seed', [
                    'module' => $moduleInfo['name'],
                ]);
                Artisan::call('module:publish', [
                    'module' => $moduleInfo['name'],
                ]);
                $addon->save(); // Save data in the database table
            } else {
                return $this->responseWithError(___('alert.Please upload addon file.'), [], 400);
            }
            return $this->responseWithSuccess(___('alert.Addon_installed_successfully.')); // Return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // Return error response
        }
    }

    public function status($id)
    {
        DB::beginTransaction();
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $courseCategoryModel = $this->model->find($id);
            if (!$courseCategoryModel) {
                return $this->responseWithError(___('alert.Course category not found.'), [], 400);
            }
            if ($courseCategoryModel->status_id == 1) {
                $message = ___('alert.Addon deactivated successfully.');
                $courseCategoryModel->status_id = 2;
                moduleUpdate($courseCategoryModel->title, false);
            } else {
                $message = ___('alert.Addon activated successfully.');
                $courseCategoryModel->status_id = 1;
                moduleUpdate($courseCategoryModel->title, true);
            }
            $courseCategoryModel->save();
            DB::commit();
            return $this->responseWithSuccess($message);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
