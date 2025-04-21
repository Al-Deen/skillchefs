<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Enums\GuardType;
use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Course\Entities\Bookmark;
use Modules\CMS\Entities\AppHomeSection;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Slider\Interfaces\SliderInterface;
use Modules\Api\Collections\CourseCategoryCollection;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Transformers\CourseDetailsResource;

class HomeController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    // constructor injection
    protected $course;
    protected $courseCategory;
    protected $slider;


    public function __construct(CourseInterface $courseInterface, CourseCategoryInterface $courseCategoryInterface, SliderInterface $slider)
    {
        $this->course               = $courseInterface;
        $this->courseCategory       = $courseCategoryInterface;
        $this->slider               = $slider;
    }


    public function index(Request $request)
    {

        try {
            $allowArray             = $this->appHomeSectionAllowArr();

            if ($allowArray[0]) {
                $data['sliders']    = $this->slider->getAllSLider();
            }

            if ($allowArray[1]) {
                $data['categories']  = new CourseCategoryCollection($this->courseCategory->model()->active()->get()); // data
            }

            $bookMarksArr = Bookmark::where('user_id',auth()->id())->pluck('course_id')->toArray() ?? [];

            $data['courses']        = $this->course->getCourse($request, $allowArray);

            if ($data['courses']) {
                return $this->responseWithSuccess(___('course.data found'), $data);
            }

            return $this->responseWithError(___('course.No data found'));
        } catch (\Throwable $th) {
            return dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function appHomeSectionAllowArr()
    {
        try {
           return  AppHomeSection::where('status_id', 1)->where('type',GuardType::API)->orderBy('order', 'asc')->pluck('snake_title')->toArray();
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

}
