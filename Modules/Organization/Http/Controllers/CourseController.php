<?php

namespace Modules\Organization\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\LanguageInterface;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Instructor\Interfaces\InstructorInterface;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Organization\Http\Requests\InstructorCommissionRequest;
use Modules\Organization\Http\Requests\UpdateInstructorCommissionRequest;
use Modules\Organization\Interfaces\InstructorCommissionInterface;

class CourseController extends Controller
{
    use ApiReturnFormatTrait, FileUploadTrait;
    // constructor injection
    protected $course;
    protected $courseCategory;
    protected $language;
    protected $enrollInterface;
    protected $instructorCommissionInterface;
    protected $instructor_interface;

    public function __construct(
        CourseInterface $courseInterface,
        CourseCategoryInterface $courseCategoryInterface,
        LanguageInterface $languageInterface,
        EnrollInterface $enrollInterface,
        InstructorCommissionInterface $instructorCommissionInterface,
        InstructorInterface $instructor_interface
    ) {
        $this->course = $courseInterface;
        $this->courseCategory = $courseCategoryInterface;
        $this->language = $languageInterface;
        $this->enrollInterface = $enrollInterface;
        $this->instructorCommissionInterface = $instructorCommissionInterface;
        $this->instructor_interface = $instructor_interface;
    }

    public function courses(Request $request)
    {
        try {
            $data['title'] = ___('organization.My Courses'); // title
            $data['courses'] = $this->course->model()
                ->where('created_by', auth()->user()->id)
                ->search($request)
                ->paginate(10);
            return view('organization::panel.organization.course.my_courses', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function addCourse()
    {
        try {
            if (Auth::user()->status_id != 4) {
                return redirect()->route('organization.courses')->with('danger', ___('alert.you_can_not_create_course!need_to_approve_first'));
            }
            $data['categories'] = $this->courseCategory->model()->active()->where('parent_id', null)->get(); // data
            $data['instructors'] = $this->instructor_interface->model()->active()->get(); // data
            $data['languages'] = $this->language->all(); // data
            $data['title'] = ___('organization.Add New Course'); // title
            return view('organization::panel.organization.course.add_course', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    //InstructorCommissionRequest
    public function storeCourse(InstructorCommissionRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request->step == 6) {
                $request['instructor'] = null;
                $result = $this->course->store($request);
                if ($result->original['result']) {
                    $request['course_id'] = $result->original['data']->id;
                    $result_instructor = $this->instructorCommissionInterface->store($request);
                    if ($result_instructor->original['result']) {
                        $data['redirect'] = route('organization.courses'); // redirect url
                        DB::commit();
                        return $this->responseWithSuccess($result->original['message'], $data); // return success response
                    } else {
                        DB::rollBack();
                        return $this->responseWithError($result_instructor->original['message'], [], 400); // return error response
                    }
                } else {
                    DB::rollBack();
                    return $this->responseWithError($result->original['message'], [], 400); // return error response
                }
            } else {
                return $this->responseWithSuccess(___('alert.Data passed correctly'));
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___($th->getMessage()), [], 400); // return error response
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
            $data['instructors'] = $this->instructor_interface->model()->active()->get(); // data
            $query = $this->instructorCommissionInterface->model()->where('course_id', $data['course']->id);
            $data['instructor_commission'] = $query->clone()->get(); // data
            $data['instructor_id_values'] = $query->clone()->select('user_id')->pluck('user_id'); // data

            $data['languages'] = $this->language->all(); // data
            $data['title'] = ___('organization.Edit Course'); // title
            return view('organization::panel.organization.course.edit_course', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updateCourse(UpdateInstructorCommissionRequest $request, $slug)
    {
        try {
            DB::beginTransaction();
            $data['course'] = $this->course->model()->where('slug', $slug)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['course']) {
                return redirect()->back()->with('danger', ___('alert.Course not found'));
            }
            Session::put('course_step', ($request->step + 1));
            if ($request->step == 9) {
                $result = $this->course->update($request, $data['course']->id);
                if ($result->original['result']) {
                    // update instructor commission
                    $result_instructor = $this->instructorCommissionInterface->update($request, $data['course']->id);
                    // update instructor commission end
                    if ($result_instructor->original['result']) {
                        $data['redirect'] = route('organization.courses'); // redirect url
                        DB::commit();
                        return $this->responseWithSuccess($result->original['message'], $data); // return success response
                    } else {
                        DB::rollBack();
                        return $this->responseWithError($result_instructor->original['message'], [], 400); // return error response
                    }
                } else {
                    DB::rollBack();
                    return $this->responseWithError($result->original['message'], [], 400); // return error response
                }
            } else {                
                return $this->responseWithSuccess(___('alert.Data passed correctly'), Session::get('course_step'));
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___($th->getMessage()), [], 400); // return error response
        }
    }

    // review
    public function courseReviews(Request $request)
    {
        try {
            $data['title'] = ___('organization.Feedbacks & Reviews'); // title
            $data['course'] = $this->course->model()
                ->search($request)
                ->where('created_by', auth()->user()->id)
                ->paginate(10);
            return view('organization::panel.organization.course.course_review', compact('data'));
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
            return view('organization::panel.organization.enroll.enrolled_student', compact('data'));
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
            return view('organization::panel.organization.course.sales', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function deleteCourse($course_id)
    {
        try {
            $result = $this->course->destroy($course_id);
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
