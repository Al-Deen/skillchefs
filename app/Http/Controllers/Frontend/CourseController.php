<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Interfaces\CourseInterface;

class CourseController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $course;
    protected $courseCategory;

    public function __construct(
        CourseInterface $courseInterface,
        CourseCategoryInterface $courseCategoryInterface
    ) {
        $this->course = $courseInterface;
        $this->courseCategory = $courseCategoryInterface;
    }

    public function index(Request $request)
    {
        try {
            $data['title'] = ___('frontend.Courses'); // title
            $search = $this->course->model()->active();
            $data['instructors'] = $search->clone()->select('created_by')->with('instructor:name,id')->groupBy('created_by')->get();
            $data['categories'] = $search->clone()->select('course_category_id')->with('category:id,title')->groupBy('course_category_id')->get();
            $data['languages'] = $search->clone()->select('language')->with('lang:name,code')->groupBy('language')->get();
            return view('frontend.course.courses', compact('data')); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function breadcrumb()
    {
        try {
            $data['title'] = ___('course.Courses');
            $html = view('frontend.ajax.courses.ot_breadcrumb_area', compact($data))->render();
            return $this->responseWithSuccess(___('alert.Data found.'), $html); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function courseList()
    {

        try {
            $options = [];
            $data = [
                'content' => view('frontend.ajax.courses.ot_course_list', ['options' => $options])->render(),
                'message' => ___('frontend.Course List'),
            ];
            return $this->responseWithSuccess(___('alert.Data found.'), $data); // return success response from ApiReturnFormatTrait

        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    // start ajax course list by filterCourse method
    public function filterCourse(Request $req)
    {
        try {
            $data = [];
            $data['courses'] = $this->course->model()->active()->visible()->filter($req)->sort($req)->paginate(10);
            $html = view('frontend.partials.render.course_list', compact('data'))->render();
            $content = [
                'content' => $html,
                'total' => '<p class="page-total">' . ___('frontend.Showing') . ' <span class="text-tertiary">' . $data['courses']->lastItem() . '</span> ' . ___('frontend.of total') . ' <span class="text-tertiary">' . $data['courses']->total() . ' </span> ' . ___('course.Courses') . ' </p>',
            ];
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $content); // return success response from ApiReturnFormatTrait

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
    // end ajax course list by filterCourse method

    // search filter
    public function searchFilter(Request $req)
    {
        try {
            $key = $req->query('query');
            if (@$key == null || strlen($key) <= 2) {
                return redirect()->route('home')->with('danger', ___('alert.At_least_3_character_required'));
            }
            $data = [];
            $search = $this->course->model()->active()->search($req);
            $data['instructors'] = $search->clone()->select('created_by')->with('instructor:name,id')->groupBy('created_by')->get();
            $data['categories'] = $search->clone()->select('course_category_id')->with('category:id,title')->groupBy('course_category_id')->get();
            $data['languages'] = $search->clone()->select('language')->with('lang:name,code')->groupBy('language')->get();
            $data['title'] = ___('frontend.Search Result');
            return view('frontend.course.courses', compact('data'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    // category

    public function category(Request $request)
    {
        try {
            $search = $this->course->model()->active();
            if (@$request->q) {
                $data['category'] = $this->courseCategory->filter(['slug' => $request->q])->active()->first();
                if (!$data['category']) {
                    return redirect()->route('home')->with('danger', ___('alert.category_not_found'));
                }
                $search = $search->filter(['course_category_id' => $data['category']->id]);
                $data['categories'] = $search->whereNotIn('course_category_id', [$data['category']->id])->clone()->select('course_category_id')->with('category:id,title')->groupBy('course_category_id')->get();
            } else {
                $data['categories'] = $search->clone()->select('course_category_id')->with('category:id,title')->groupBy('course_category_id')->get();
            }
            $data['instructors'] = $search->clone()->select('created_by')->with('instructor:name,id')->groupBy('created_by')->get();
            $data['languages'] = $search->clone()->select('language')->with('lang:name,code')->groupBy('language')->get();
            $data['title'] = ___('frontend.Course Result');
            return view('frontend.course.courses', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
