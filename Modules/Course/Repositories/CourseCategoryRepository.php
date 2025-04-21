<?php

namespace Modules\Course\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Course\Entities\CourseCategory;
use Modules\Course\Interfaces\CourseCategoryInterface;

class CourseCategoryRepository implements CourseCategoryInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(CourseCategory $courseCategoryModel)
    {
        $this->model = $courseCategoryModel;
    }

    public function all()
    {
        try {
            return $this->model->get();
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function model()
    {
        try {
            return $this->model;
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function filter($filter = null)
    {
        $model = $this->model;
        if (@$filter) {
            $model = $this->model->where($filter);
        }
        return $model;
    }

    public function store($request)
    {

        if (env('APP_DEMO')) {
            return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
        }
        DB::beginTransaction(); // start database transaction
        try {
            $courseCategoryModel = new $this->model; // create new object of model for store data in database table
            $courseCategoryModel->title = $request->title;
            $courseCategoryModel->slug = Str::slug($request->title) . '-' . Str::random(8);
            $courseCategoryModel->parent_id = @$request->parent_id;
            $courseCategoryModel->status_id = $request->status_id;
            $courseCategoryModel->user_id = auth()->user()->id;
            // icon upload
            if ($request->hasFile('icon')) {
                $upload = $this->uploadFile($request->icon, 'course/category/icons/icon', [[35, 35]], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $courseCategoryModel->icon = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $courseCategoryModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Course category created successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function show($id)
    {
        try {
            return $this->model->find($id);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function update($request, $id)
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
            $courseCategoryModel->title = $request->title;
            if ($request->title != $courseCategoryModel->title) {
                $courseCategoryModel->slug = Str::slug($request->title) . '-' . Str::random(8);
            }
            $courseCategoryModel->parent_id = @$request->parent_id;
            $courseCategoryModel->status_id = $request->status_id;
            $courseCategoryModel->user_id = auth()->user()->id;
            // icon upload
            if ($request->hasFile('icon')) {
                $upload = $this->uploadFile($request->icon, 'course/category/icons/icon', [[35, 35]], @$courseCategoryModel->icon, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $courseCategoryModel->icon = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $courseCategoryModel->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Course category updated successfully.'));
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

            $courseCategoryModel = $this->model->find($id);
            $upload = $this->deleteFile($courseCategoryModel->icon, 'delete'); // delete file from storage
            if (!$upload['status']) {
                return $this->responseWithError($upload['message'], [], 400); // return error response
            }
            $courseCategoryModel->delete();
            return $this->responseWithSuccess(___('alert.Course category deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function popularStatus($id)
    {
        try {
            $courseCategoryModel = $this->model->find($id);
            if (!$courseCategoryModel) {
                return $this->responseWithError(___('alert.Popular_course_category_not_found.'), [], 400);
            }
            if ($courseCategoryModel->is_popular == 1) {
                $courseCategoryModel->is_popular = 0;
                $courseCategoryModel->save();
                return $this->responseWithSuccess(___('alert.Popular_course_category_updated_successfully.'));
            } else {
                $courseCategoryModel->is_popular = 1;
                $courseCategoryModel->save();
                return $this->responseWithSuccess(___('alert.Popular_course_category_added_successfully.'));
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function popularCategory()
    {
        if (Cache::has('popular_course_category')) {
            return Cache::get('popular_course_category');
        } else {
            $popularCategory = $this->model->where('is_popular', 1)->active()->select('id', 'title', 'icon', 'slug')->with('iconImage:id,paths')->take(9)->get();
            Cache::put('popular_course_category', $popularCategory);
            return $popularCategory;
        }
    }
}
