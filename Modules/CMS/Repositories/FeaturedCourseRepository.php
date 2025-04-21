<?php

namespace Modules\CMS\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\CMS\Entities\FeaturedCourse;
use Modules\CMS\Interfaces\FeaturedCourseInterface;

class FeaturedCourseRepository implements FeaturedCourseInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(FeaturedCourse $featuredCourse)
    {
        $this->model = $featuredCourse;
    }

    public function model()
    {
        return $this->model;

    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $featured = new $this->model;
            $featured->course_id = $request->course_id;
            $featured->status_id = $request->status_id;
            $featured->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Featured course created successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $featured = $this->model->find($id);
            if (!$featured) {
                return $this->responseWithError(___('alert.Featured_course_not_found.'), [], 400);
            }
            $featured->course_id = $request->course_id;
            $featured->status_id = $request->status_id;
            $featured->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Featured course updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $featured = $this->model->find($id);
            if (!$featured) {
                return $this->responseWithError(___('alert.Featured_course_not_found.'), [], 400);
            }
            $featured->delete();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Featured course deleted successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
