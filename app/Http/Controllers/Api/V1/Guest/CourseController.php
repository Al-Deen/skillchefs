<?php

namespace App\Http\Controllers\Api\V1\Guest;

use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Interfaces\LanguageInterface;
use Modules\Course\Entities\Bookmark;
use Illuminate\Contracts\Support\Renderable;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Course\Http\Requests\CourseRequest;
use Modules\Course\Transformers\CourseResource;
use Modules\Course\Transformers\CourseCollection;
use Modules\Course\Transformers\SeeAllCourseResource;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Transformers\CourseDetailsResource;
use Modules\Course\Transformers\SeeAllCourseCollection;
use Modules\Course\Transformers\CourseCurriculumLessonResource;
use Modules\Course\Transformers\CourseCurriculumSectionResource;

class CourseController extends Controller
{
    use ApiReturnFormatTrait;


    // constructor injection
    protected $course;
    protected $courseCategory;
    protected $language;

    public function __construct(
        CourseInterface $courseInterface,
        CourseCategoryInterface $courseCategoryInterface,
        LanguageInterface $languageInterface
        )
    {
        $this->course = $courseInterface;
        $this->courseCategory = $courseCategoryInterface;
        $this->language = $languageInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $courses = $this->course->model()->with('category')->filter($request)->paginate($request->show ?? 10); // data
            $courseArr =  new CourseResource($courses);
            if($courseArr){
                return $this->responseWithSuccess(___('course.data found'), $courseArr);
            }

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }


    public function courseDetails(Request $request)
    {
        try {
            $course = $this->course->model()
                ->with('instructor:id,name', 'thumbnailImage', 'courseType')
                ->findOrFail($request->id);

            if (blank($course)) {
                return $this->responseWithError(___('alert.Course not found.'), [], 400);
            }
            $data = [
                'details' => new CourseDetailsResource($course),
                'curriculum' => new CourseCurriculumSectionResource($course),
            ];

            return $this->responseWithSuccess(___('course.data found'), $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400);
        }
    }

    public function seeAllCourses(Request $request)
    {

        try {

            $bookMarksArr = Bookmark::where('user_id',auth()->id())->pluck('course_id')->toArray() ?? [];

            $courses = $this->course->model()->with('instructor:id,name')->select('id', 'title', 'price', 'discount_price', 'thumbnail', 'rating', 'total_sales', 'total_review', 'is_free', 'is_discount', 'created_by', 'created_at', 'updated_at')->courseByType($request)->get();


            $courseArr = [];
            foreach($courses as $course){
                $courseArr[] = [
                    'id'                => @$course->id,
                    'title'             => @$course->title,
                    'price'             => !empty($course->price) ? $course->price : 0,
                    'discount_price'    => !empty($course->discount_price) ? $course->discount_price : 0,
                    'image'             => !empty($course->thumbnailImage->original) ? url($course->thumbnailImage->original) : '',
                    'rate'              => @$course->rating,
                    'total_sales'       => @$course->total_sales,
                    'reviewCount'       => !empty($course->total_review) ? $course->total_review : 0,
                    'is_free'           => @$course->is_free,
                    'is_discount'       => @$course->is_discount,
                    'created_at'        => @$course->created_at,
                    'course_creator'    => @$course->instructor->name,
                    'details'           => route('home.api.course.details', @$course->id),
                    'is_bookmark'       => @$course->userBookmark->count() > 0,
                    'is_purchased'      => @auth()->user()->userCourseEnroll->where('course_id', @$course->id)->count() > 0,
                ];

            }

            if($courseArr){
                return $this->responseWithSuccess(___('course.data found'), $courseArr);
            }

        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

}
