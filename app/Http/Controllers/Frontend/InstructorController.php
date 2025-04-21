<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Instructor\Interfaces\InstructorInterface;

class InstructorController extends Controller
{
    use ApiReturnFormatTrait;

    protected $instructor;
    protected $course;
    protected $courseCategory;

    // constructor injection
    public function __construct(
        InstructorInterface $instructorInterface,
        CourseInterface $courseInterface,
        CourseCategoryInterface $courseCategoryInterface
    ) {
        $this->instructor = $instructorInterface;
        $this->course = $courseInterface;
        $this->courseCategory = $courseCategoryInterface;
    }

    public function index(Request $request)
    {

        try {
            $data['title'] = ___('frontend.Instructors'); // title
            $data['instructor'] = $this->instructor->model()->with(['user'])->whereHas('user', function ($query) {
                $query->where('status', 1);
            })->paginate(5);

            if (Cache::has('instructor_categories')) {
                $categories = Cache::get('instructor_categories');
            } else {
                $categories = $this->courseCategory->model()->active()->select('title', 'id')->get();
                Cache::put('instructor_categories', $categories);
            }
            $data['categories'] = $categories;
            if (Cache::has('instructor_languages')) {
                $data['languages'] = Cache::get('instructor_languages');
            } else {
                $data['languages'] = $this->course->model()->select('language')->groupBy('language')->get();
                Cache::put('instructor_languages', $data['languages']);
            }
            return view('frontend.instructor.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function filterInstructor(Request $req)
    {
        try {
            $data = [];
            $data['instructors'] = $this->instructor->model()->filter($req)->paginate(5);
            $html = view('frontend.partials.render.instructor_list', compact('data'))->render();
            $content = [
                'content' => $html,
                'total' => '',
            ];
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $content); // return success response from ApiReturnFormatTrait

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function details($name, $id)
    {
        try {
            $data['title'] = ___('frontend.Instructor Details'); // title
            $data['instructor'] = $this->instructor->model()->where('user_id', $id)->first();
            if (!$data['instructor']) {
                return redirect()->route('home')->with('danger', ___('alert.Instructor_not_found'));
            }
            $data['courses'] = $this->course->model()->where('created_by',  $data['instructor']->user->id)->active()->visible()->paginate(4);
            return view('frontend.instructor.details', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
