<?php

namespace Modules\CMS\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\CMS\Entities\Testimonial;
use Modules\CMS\Interfaces\TestimonialInterface;

class TestimonialRepository implements TestimonialInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(Testimonial $testimonial)
    {
        $this->model = $testimonial;
    }

    public function model()
    {
        try {
            return $this->model;

        } catch (\Throwable $th) {

            return false;
        }

    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $testimonial = $this->model;
            $testimonial->name = $request->name;
            $testimonial->designation = $request->designation;
            $testimonial->rating = $request->rating;
            $testimonial->content = $request->content;
            $testimonial->status_id = $request->status_id;
            $testimonial->save();

            if ($request->hasFile('image_id')) {
                $upload = $this->uploadFile($request->image_id, 'cms/testimonials/testimonial', [], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $testimonial->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $testimonial->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Testimonial store successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $testimonial = $this->model->find($id);
            if (!$testimonial) {
                return $this->responseWithError(___('alert.testimonial_not_found'), [], 400);
            }
            $testimonial->name = $request->name;
            $testimonial->designation = $request->designation;
            $testimonial->rating = $request->rating;
            $testimonial->content = $request->content;
            $testimonial->status_id = $request->status_id;
            $testimonial->save();

            if ($request->hasFile('image_id')) {
                $upload = $this->uploadFile($request->image_id, 'cms/testimonials/testimonial', [], @$testimonial->image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $testimonial->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $testimonial->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Testimonial updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            
            $testimonial = $this->model->find($id);
            $upload = $this->deleteFile($testimonial->image_id, 'delete'); // delete file from storage
            if (!$upload['status']) {
                return $this->responseWithError($upload['message'], [], 400); // return error response
            }
            $testimonial->delete();
            return $this->responseWithSuccess(___('alert.Testimonial deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
