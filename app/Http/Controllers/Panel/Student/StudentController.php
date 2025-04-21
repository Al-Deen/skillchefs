<?php

namespace App\Http\Controllers\Panel\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Interfaces\BookmarkInterface;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Order\Interfaces\NoteInterface;
use Modules\Order\Repositories\EnrollRepository;
use Modules\Student\Interfaces\StudentInterface;

class StudentController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $user;
    protected $student;
    protected $enrollRepository;
    protected $noteRepository;
    protected $bookmarkRepository;
    protected $template = 'panel.student';

    public function __construct(
        User $user,
        StudentInterface $student,
        EnrollInterface $enrollRepository,
        BookmarkInterface $bookmarkRepository,
        NoteInterface $noteRepository
    ) {
        $this->user = $user;
        $this->student = $student;
        $this->enrollRepository = $enrollRepository;
        $this->noteRepository = $noteRepository;
        $this->bookmarkRepository = $bookmarkRepository;
    }

    public function dashboard()
    {
        try {

            $data['student'] = $this->student->model()->where('user_id', Auth::id())->first();
            $data['title'] = ___('student.Student Dashboard'); // title
            return view($this->template . '.student_dashboard', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function profile()
    {
        try {
            $data['title'] = ___('student.My Profile'); // title
            $data['student'] = $this->student->model()->where('user_id', Auth::id())->first();
            return view($this->template . '.student_profile', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function courses(Request $request)
    {
        try {
            $data['title'] = ___('student.Student Courses'); // title
            $data['enrolls'] = $this->enrollRepository->model()->where('user_id', Auth::id())->with('course:id,title,course_duration,course_category_id,slug,thumbnail')
                ->search($request)
                ->latest()
                ->paginate(10);
            return view($this->template . '.my_courses', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function tabLoad(Request $request)
    {
        try {
            if (@$request->tab && $request->enrollId) {
                $data['enroll'] = $this->enrollRepository->model()->find(decryptFunction($request->enrollId));
                if (!$data['enroll']) {
                    return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
                }
                if ($request->tab == 'Notes') {
                    $view = view($this->template . '.course.tab.notes', compact('data'))->render();
                    return $this->responseWithSuccess(___('alert.Data found'), $view);
                } elseif ($request->tab == 'Announcement') {
                    $announcement = $this->enrollRepository->model()->announcements($data['enroll']);
                    return $this->responseWithSuccess(___('alert.Data found'), @$announcement);
                } elseif ($request->tab == 'Assignment') {
                    $view = view($this->template . '.course.tab.assignment', compact('data'))->render();
                    return $this->responseWithSuccess(___('alert.Data found'), $view);
                } elseif ($request->tab == 'Review') {
                    $view = view($this->template . '.course.tab.reviews', compact('data'))->render();
                    return $this->responseWithSuccess(___('alert.Data found'), $view);
                } else {
                    return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
                }
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function courseLearn($slug, $lesson_id)
    {
        try {
            $lesson_id = decryptFunction($lesson_id);
            $data['title'] = ___('student.Student Course Learn'); // title
            $data['enroll'] = $this->enrollRepository->model()->where('user_id', Auth::id())->whereHas('course', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })->with('course:id,title,slug,course_duration,created_by,requirements,outcomes,description', 'lessons')->first();
            $data['lesson'] = $data['enroll']->lessons->find($lesson_id);
            if (!$data['enroll'] || !$data['lesson']) {
                return redirect()->back()->with('danger', ___('alert.Lesson not found'));
            }
            $this->enrollRepository->visited($data['enroll']);
            $data['lesson_id'] = $lesson_id;
            return view($this->template . '.course.course_details', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function courseEnrollProgress(Request $request)
    {
        try {
            $result = $this->enrollRepository->update($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess(___('alert.Lesson_successfully_updated'));
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    // course activities
    public function courseActivities(Request $request)
    {
        try {
            $data['enrolls'] = $this->enrollRepository->model()->where('user_id', Auth::id())->with('course:id,title,course_duration,point,course_category_id,slug')
                ->search($request)
                ->latest()
                ->paginate(10);
            $data['title'] = ___('student.Course Activities'); // title
            return view($this->template . '.course_activities', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // course activities

    public function leaderBoard()
    {
        try {
            $data['title'] = ___('student.Leaderboard'); // title
            $data['students'] = $this->student->model()->orderBy('points', 'DESC')->paginate(10);
            return view($this->template . '.leader_board', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function logout()
    {
        try {
            auth()->logout();

            return redirect()->route('home')->with('success', ___('alert.Student Log out successfully!!'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
