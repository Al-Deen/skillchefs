<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Http\Controllers\Controller;
use App\Interfaces\LanguageInterface;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Course\Http\Requests\Instructor\CourseRequest;
use Modules\Course\Http\Requests\Instructor\UpdateCourseRequest;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Order\Interfaces\EnrollInterface;

class CourseController extends Controller
{
    use ApiReturnFormatTrait, FileUploadTrait;
    // constructor injection
    protected $course;
    protected $courseCategory;
    protected $language;
    protected $enrollInterface;

    public function __construct(
        CourseInterface $courseInterface,
        CourseCategoryInterface $courseCategoryInterface,
        LanguageInterface $languageInterface,
        EnrollInterface $enrollInterface
    ) {
        $this->course = $courseInterface;
        $this->courseCategory = $courseCategoryInterface;
        $this->language = $languageInterface;
        $this->enrollInterface = $enrollInterface;
    }

    public function courses(Request $request)
    {
        try {
            $data['title'] = ___('instructor.My Courses'); // title
            $data['courses'] = $this->course->model()
                ->where('created_by', auth()->user()->id)
                ->search($request)
                ->paginate(10);
            return view('panel.instructor.course.my_courses', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function addCourse()
    {
        try {
            if (Auth::user()->status_id != 4) {
                return redirect()->route('instructor.courses')->with('danger', ___('alert.you_can_not_create_course!need_to_approve_first'));
            }
            $data['categories'] = $this->courseCategory->model()->active()->where('parent_id', null)->get(); // data
            $data['languages'] = $this->language->all(); // data
            $data['title'] = ___('instructor.Add New Course'); // title
            return view('panel.instructor.course.add_course', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function storeCourse(CourseRequest $request)
    {
        try {
            if ($request->step == 5) {
                $request['instructor'] = auth()->user()->id;
                $result = $this->course->store($request);
                if ($result->original['result']) {
                    $data['redirect'] = route('instructor.courses'); // redirect url
                    return $this->responseWithSuccess($result->original['message'], $data); // return success response
                } else {
                    return $this->responseWithError($result->original['message'], [], 400); // return error response
                }
            } else {
                return $this->responseWithSuccess(___('alert.Data passed correctly'));
            }
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function editCourse($slug)
    {
        try {
            $data['course'] = $this->course->model()->where('slug', $slug)->where('created_by', auth()->user()->id)->with('sections')->first(); // data
            if (!$data['course']) {
                return redirect()->back()->with('danger', ___('alert.Course not found'));
            }
            $data['categories'] = $this->courseCategory->model()->active()->where('parent_id', null)->get(); // data
            $data['languages'] = $this->language->all(); // data
            $data['title'] = ___('instructor.Edit Course'); // title
            return view('panel.instructor.course.edit_course', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updateCourse(UpdateCourseRequest $request, $slug)
    {
        try {
            $data['course'] = $this->course->model()->where('slug', $slug)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['course']) {
                return redirect()->back()->with('danger', ___('alert.Course not found'));
            }
            Session::put('course_step', ($request->step + 1));
            if ($request->step == 8) {
                $request['instructor'] = auth()->user()->id;
                $result = $this->course->update($request, $data['course']->id);
                if ($result->original['result']) {
                    $data['redirect'] = route('instructor.courses'); // redirect url
                    return $this->responseWithSuccess($result->original['message'], $data); // return success response
                } else {
                    return $this->responseWithError($result->original['message'], [], 400); // return error response
                }
            } else {
                return $this->responseWithSuccess(___('alert.Data passed correctly'), Session::get('course_step'));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    // review
    public function courseReviews(Request $request)
    {
        try {
            $data['title'] = ___('instructor.Feedbacks & Reviews'); // title
            $data['course'] = $this->course->model()
                ->search($request)
                ->where('created_by', auth()->user()->id)
                ->paginate(10);
            return view('panel.instructor.course.course_review', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    // enroll
    public function enrolledStudent(Request $request)
    {
        try {
            $data['enrolledStudent'] = $this->enrollInterface->model()
                ->search($request)
                ->with('user')
                ->where('instructor_id', auth()->user()->id)
                ->paginate(10);
            $data['title'] = ___('instructor.Enrolled Student'); // title
            return view('panel.instructor.enroll.enrolled_student', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // sales
    public function sales(Request $request)
    {
        try {
            $data['title'] = ___('instructor.Course Sales'); // title
            $data['courses'] = $this->course->model()
                ->search($request)
                ->where('created_by', auth()->user()->id)
                ->paginate(10);
            return view('panel.instructor.course.sales', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function deleteCourse($course_id)
    {
        try {
            $result  = $this->course->destroy($course_id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

}
