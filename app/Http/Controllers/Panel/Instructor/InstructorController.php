<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Interfaces\LanguageInterface;
use Modules\Order\Interfaces\OrderInterface;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Course\Repositories\ReviewRepository;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Instructor\Interfaces\InstructorInterface;

class InstructorController extends Controller
{
    use ApiReturnFormatTrait, FileUploadTrait;

    protected $instructor;
    protected $user;
    protected $courseInterface;
    protected $courseCategoryRepository;
    protected $languageRepository;
    protected $enrollInterface;
    protected $orderInterface;
    protected $reviewRepository;

    public function __construct(
        InstructorInterface $instructor,
        CourseInterface $courseInterface,
        CourseCategoryInterface $courseCategoryInterface,
        LanguageInterface $languageInterface,
        User $user,
        EnrollInterface $enrollInterface,
        OrderInterface $orderInterface,
        ReviewRepository $reviewRepository
    ) {
        $this->instructor = $instructor;
        $this->user = $user;
        $this->courseInterface = $courseInterface;
        $this->courseCategoryRepository = $courseCategoryInterface;
        $this->languageRepository = $languageInterface;
        $this->enrollInterface = $enrollInterface;
        $this->orderInterface = $orderInterface;
        $this->reviewRepository = $reviewRepository;
    }

    //Dashboard related method
    public function dashboard()
    {
        try {
            $data['title'] = ___('instructor.Instructor'); // title
            $data['instructor'] = $this->instructor->model()->where('user_id', auth()->user()->id)->first();
            $data['reviews']  =  $this->reviewRepository->model()->instructor()->latest()->take(5)->get();
            $data['courses'] = $this->courseInterface->model()->where('created_by', auth()->user()->id)->orderBy('total_sales','DESC')->take(5)->get();
            return view('panel.instructor.dashboard', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function monthlySales(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->orderInterface->instructorMonthlySales($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $result->original['data']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } else {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function profile()
    {
        try {
            $data['title'] = ___('instructor.Profile'); // title
            $data['instructor'] = $this->instructor->model()->with('user')->where('user_id', auth()->user()->id)->first();

            return view('panel.instructor.profile', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updateProfile(Request $request)
    {

        try {
            $result = $this->instructor->updateProfile($request, auth()->user()->id);

            if ($result->original['result']) {
                return redirect()->route('instructor.setting')->with('success', $result->original['message']);
            } else {
                return redirect()->route('instructor.setting')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {

            return redirect()->route('instructor.setting')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function logout()
    {
        try {
            auth()->logout();

            return redirect()->route('home')->with('success', ___('alert.Instructor Log out successfully!!'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function index()
    {
        try {
            $data['title'] = ___('instructor.Instructor'); // title
            return view('panel.instructor.instractors', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function details()
    {
        try {
            $data['title'] = ___('instructor.Instructor Details'); // title

            return view('panel.instructor.instructor_details', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function uploadCourse()
    {
        try {
            $data['title'] = ___('instructor.Upload Course'); // title

            return view('panel.instructor.upload_course', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function playlist()
    {
        try {
            $data['title'] = ___('instructor.Playlist'); // title

            return view('panel.instructor.playlist', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function financialSummary()
    {
        try {
            $data['title'] = ___('instructor.Finalcial Summary'); // title

            return view('panel.instructor.financial_summary', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function notification()
    {
        try {
            $data['title'] = ___('instructor.Notification'); // title

            return view('panel.instructor.notification', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

}
