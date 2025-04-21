<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Api\Collections\CourseCollection;
use Modules\Api\Transformers\CategoryResource;
use Modules\Api\Collections\CourseCategoryCollection;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Http\Requests\CourseCategoryRequest;
use Modules\Course\Http\Requests\UpdateCourseCategoryRequest;

class CourseCategoryController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;
    // constructor injection
    protected $courseCategory;

    public function __construct(CourseCategoryInterface $courseCategory)
    {
        $this->courseCategory = $courseCategory;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function categories(Request $request)
    {
        try {

            $data['categories']     = new CourseCategoryCollection($this->courseCategory->model()->active()->where('parent_id', null)->get()); // data

            if($data['categories']){

                return $this->responseWithSuccess(___('course.data found'), $data);
            }
            return $this->responseWithError(___('alert.no data found'), [], 400); // return error response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }


    public function categoryDetails(Request $request)
    {
        try {

            $data['category']     = $this->courseCategory->model()->find($request->id); // data

            if($data['category']){
                return $this->responseWithSuccess(___('student.data found'), $data);
            }
            return $this->responseWithError(___('alert.no data found'), [], 400); // return error response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function categoryList(Request $request)
    {
        try {
            $data['category']       = new CategoryResource($this->courseCategory->model()->active()->find($request->id)); // data
            $data['courses']        = new CourseCollection($data['category']->courses()->get());

            if($data['category']){
                return $this->responseWithSuccess(___('student.data found'), $data);
            }
            return $this->responseWithError(___('alert.no data found'), [], 400); // return error response
        } catch (\Throwable $th) {
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
