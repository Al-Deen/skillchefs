<?php

namespace App\Http\Controllers\Api\V1\Student;

use App\Enums\Role;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\UserEmailVerifyEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Course\Entities\Bookmark;
use Modules\Course\Entities\Assignment;
use Illuminate\Support\Facades\Validator;
use Modules\Order\Interfaces\NoteInterface;
use Modules\Order\Http\Requests\NoteRequest;
use Modules\Course\Entities\AssignmentSubmit;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Course\Interfaces\BookmarkInterface;
use Modules\Student\Interfaces\StudentInterface;
use Modules\Api\Collections\AssignmentCollection;
use Modules\Api\Collections\CertificateCollection;
use Modules\Certificate\Entities\CertificateGenerate;
use Modules\Certificate\Entities\CertificateTemplate;
use Modules\Course\Transformers\SeeAllCourseCollection;
use App\Http\Requests\api\bookmark\BookmarkStoreRequest;
use App\Http\Requests\api\bookmark\BookmarkDeleteRequest;

class StudentController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $user;
    protected $certificateGenerateModel;
    protected $student;
    protected $enrollRepository;
    protected $noteRepository;
    protected $bookmarkRepository;
    protected $template = 'panel.student';

    public function __construct(
        User $user,
        CertificateGenerate $certificateGenerateModel,
        StudentInterface $student,
        EnrollInterface $enrollRepository,
        BookmarkInterface $bookmarkRepository,
        NoteInterface $noteRepository
    ) {
        $this->user             = $user;
        $this->student          = $student;
        $this->certificateGenerateModel = $certificateGenerateModel;
        $this->enrollRepository = $enrollRepository;
        $this->noteRepository   = $noteRepository;
        $this->bookmarkRepository = $bookmarkRepository;
    }



    public function profile()
    {

        try {
            $data['title']      = ___('student.Setting Profile'); // title
            $dataStudent    = $this->user->where('id', Auth::id())->first();
            $data['student'] = new UserResource($dataStudent);
            if($data['student']){
                return $this->responseWithSuccess(___('student.data found'), $data);
            }
            return $this->responseWithError(___('alert.no data found'), [], 400); // return error response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function courses(Request $request)
    {

        try {
            $data['title']      = ___('student.Student Courses'); // title
            $data['enrolls']    = $this->enrollRepository->model()->where('user_id', Auth::id())->with('course:id,title,course_duration,course_category_id,slug,thumbnail')
                ->search($request)
                ->latest()
                ->paginate(10);
            return view($this->template . '.my_courses', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function leaderBoard()
    {
        try {
            $data['title']      = ___('student.Leader Board'); // title
            $data['students'] = $this->student->model()->orderBy('points','asc')->paginate(10);
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

    public function myProfile(Request $request)
    {

        try {
            $data['title']      = ___('student.My Profile'); // title

            $dataStudent    = $this->user->where('id', Auth::id())->first();
            $data['student'] = new UserResource($dataStudent);

            $enrolls    = $this->enrollRepository->model()->where('user_id', Auth::id())->with('course')
            ->search($request)
            ->latest()
            ->paginate(10);


            $data['enrolls'] = new SeeAllCourseCollection($enrolls,$this->bookMarkArr());

            //Certificate
            $completeCourseArr = CertificateGenerate::where(['user_id'=>auth()->id()])->pluck('certificate_id')->toArray();

            $certificate = $this->certificateGenerateModel->where('user_id', auth()->id())->get();

            $data['certificates'] = new CertificateCollection($certificate);
             //Certificate

            //Assignment
            $data['assignment'] = new AssignmentCollection(Assignment::whereIn('course_id',auth()->user()->purchaseCourses()->pluck('course_id'))->get());
            //Assignment

            // dd($data['assignment']->toArray());

            return $this->responseWithSuccess(___('student.data found'), $data);

            return $this->responseWithError(___('alert.no data found'), [], 400); // return error response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function bookMarkArr(){
        try{
            return Bookmark::where('user_id',auth()->id())->pluck('course_id')->toArray() ?? [];
        }
        catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }


    }
}
