<?php

namespace Modules\CMS\Repositories;

use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Modules\CMS\Entities\ImageGallery;
use Modules\CMS\Interfaces\ImageGalleryInterface;

class ImageGalleryRepository implements ImageGalleryInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(ImageGallery $imageGallery)
    {
        $this->model = $imageGallery;
    }

    public function model()
    {
        try {
            return $this->model;

        } catch (\Throwable $th) {

            return false;
        }

    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            
            $gallery = $this->model->find($id);
            if (!$gallery) {
                return $this->responseWithError(___('alert.Gallery_Image_not_found'), [], 400);
            }
            $gallery->title = $request->title;
            $gallery->status_id = $request->status_id;
            $gallery->save();
            if ($request->hasFile('image_file')) {
                $upload = $this->uploadFile($request->image_file, 'cms/galleries/gallery', [], $gallery->image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $gallery->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $gallery->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Gallery_Image_updated_successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
