<?php

namespace App\Http\Controllers\Panel\Student;

use App\Http\Controllers\Controller;
use App\Models\LiveSupport;
use App\Models\Support;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
            $data['enrolls'] = $this->enrollRepository->model()->whereNotNull('course_id')->where('user_id', Auth::id())->with('course:id,title,course_duration,course_category_id,slug,thumbnail')
                ->search($request)
                ->latest()
                ->paginate(10);
            return view($this->template . '.my_courses', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function books(Request $request)
    {
        try {
            $data['title'] = ___('student.Student Books'); // title
            $data['enrolls'] = $this->enrollRepository->model()->whereNotNull('book_id')->where('user_id', Auth::id())->with('book:id,title,slug,thumbnail')
                ->search($request)
                ->latest()
                ->paginate(10);
            return view($this->template . '.my_books', compact('data'));
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


            $data['support'] = Support::where('course_id',$data['enroll']->course_id)->where('status',1)->latest()->first();
            // join support link - show
            if ($data['support']) {
            $data['aciveLiveSupportData'] = LiveSupport::with('support')->where('support_id',$data['support']->id)->where('course_id',$data['support']->course_id)->where('user_id',Auth::id())->first();
            $data['liveSupportData'] = LiveSupport::with('support')->where('support_id',$data['support']->id)->where('course_id',$data['support']->course_id)->where('user_id',Auth::id())->first();

                if ($data['liveSupportData']) {
                    $pendingRequests = LiveSupport::where('support_id', $data['support']->id)
                        ->where('course_id', $data['enroll']->course_id)
                        ->orderBy('created_at')
                        ->get();

                    $serial = 0;
                    $waitingTime = 0;
                    $statusOneOrTwoExists = false;
                    $serialCounter = 1;

                    foreach ($pendingRequests as $index => $request) {
                        if ($request->status == 1 || $request->status == 2) {
                            // Active or processing
                            if ($request->user_id == Auth::id()) {
                                $serial = 1;
                            }
                            $statusOneOrTwoExists = true;
                        } elseif ($request->status == 0) {
                            if (!$statusOneOrTwoExists) {
                                $serialCounter = 1;
                            } else {
                                $serialCounter++;
                            }

                            if ($request->user_id == Auth::id()) {
                                $serial = $serialCounter;
                            }
                        }

                        // Waiting time calculation (already correct)
                        if ($request->user_id == Auth::id() && ($request->status == 0 || $request->status == 1)) {
                            $previousEndTime = Carbon::parse($request->start_time);
                            $now = Carbon::now('Asia/Dhaka');
                            $waitingTime = $previousEndTime->gt($now)
                                ? $now->diffInMinutes($previousEndTime)
                                : 0;
                        }
                    }

                    $data['liveSupportSerial'] = $serial;
                    $data['waitingTime'] = $waitingTime;
                }
            }


            return view($this->template . '.course.course_details', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function BookLearn($slug)
    {
        try {
            $data['title'] = ___('student.Student Book Learn'); // title
            $data['enroll'] = $this->enrollRepository->model()->where('user_id', Auth::id())->whereHas('book', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })->with('book')->first();
            return view($this->template . '.book_details', compact('data'));
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
            $data['enrolls'] = $this->enrollRepository->model()->whereNotNull('course_id')->where('user_id', Auth::id())->with('course:id,title,course_duration,point,course_category_id,slug')
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


    public function supportRequest(Request $request)
    {
        $request->validate([
            'support_id' => 'required|exists:supports,id',
            'course_id' => 'required|exists:courses,id',
            'question' => 'required|string',
        ]);

        $support = Support::findOrFail($request->support_id);
        $intervalMinutes = $support->interval;

        $existingLiveSupports = LiveSupport::where('support_id', $support->id)
            ->orderByDesc('end_time')
            ->first();

        // Always start with seconds = 0
        $currentTime = Carbon::now('Asia/Dhaka')->minute(Carbon::now()->minute)->second(0);

        if (!$existingLiveSupports) {
            $startTime = $currentTime;
        } else {
            $lastEndTime = Carbon::parse($existingLiveSupports->end_time)->setSecond(0);
            $startTime = $currentTime->lt($lastEndTime) ? $lastEndTime : $currentTime;
        }

        // Force both start and end time seconds to 0
        $startTime->setSecond(0);
        $endTime = (clone $startTime)->addMinutes($intervalMinutes)->setSecond(0);

        LiveSupport::create([
            'support_id' => $support->id,
            'course_id' => $request->course_id,
            'user_id' => auth()->id(),
            'question' => $request->question,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 0,
        ]);

        return back()->with('success', 'Support request submitted successfully.');
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
