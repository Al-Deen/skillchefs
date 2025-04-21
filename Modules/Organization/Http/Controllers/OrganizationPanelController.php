<?php

namespace Modules\Organization\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Traits\FileUploadTrait;
use App\Traits\ApiReturnFormatTrait;
use Modules\Organization\Http\Requests\OrganizationCreate;
use App\Interfaces\LanguageInterface;
use Modules\Order\Interfaces\OrderInterface;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Course\Repositories\ReviewRepository;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Organization\Interfaces\OrganizationInterface;
use Modules\Instructor\Interfaces\InstructorInterface;
use Modules\Instructor\Http\Requests\InstructorRequest;
use Modules\Instructor\Http\Requests\PasswordRequest;
use Modules\Instructor\Http\Requests\SkillRequest;

class OrganizationPanelController extends Controller
{
    use ApiReturnFormatTrait, FileUploadTrait;

    protected $organization;
    protected $user;
    protected $courseInterface;
    protected $courseCategoryRepository;
    protected $languageRepository;
    protected $enrollInterface;
    protected $orderInterface;
    protected $reviewRepository;
    protected $instructorRepository;

    public function __construct(
        OrganizationInterface $organization,
        CourseInterface $courseInterface,
        CourseCategoryInterface $courseCategoryInterface,
        LanguageInterface $languageInterface,
        User $user,
        EnrollInterface $enrollInterface,
        OrderInterface $orderInterface,
        ReviewRepository $reviewRepository,
        InstructorInterface $instructorRepository,
    ) {
        $this->organization = $organization;
        $this->user = $user;
        $this->courseInterface = $courseInterface;
        $this->courseCategoryRepository = $courseCategoryInterface;
        $this->languageRepository = $languageInterface;
        $this->enrollInterface = $enrollInterface;
        $this->orderInterface = $orderInterface;
        $this->reviewRepository = $reviewRepository;
        $this->instructorRepository = $instructorRepository;
    }

    public function dashboard()
    {
        try {
            $data['title'] = ___('organization.Organization'); // title
            $data['organization'] = $this->organization->model()->where('user_id', auth()->user()->id)->first();
            $data['reviews'] = $this->reviewRepository->model()->instructor()->latest()->take(5)->get();
            $data['courses'] = $this->courseInterface->model()->where('created_by', auth()->user()->id)->orderBy('total_sales','DESC')->take(5)->get();
            return view('organization::panel.organization.dashboard', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function monthlySales(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->orderInterface->organizationMonthlySales($request);
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
            $data['organization'] = $this->organization->model()->with('user')->where('user_id', auth()->user()->id)->first();

            return view('organization::panel.organization.profile', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function logout()
    {
        try {
            auth()->logout();
            return redirect()->route('home')->with('success', ___('alert.Organization Log out successfully!!'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function instructorIndex(Request $request){
        try {
            $data['title'] = ___('organization.Instructor List'); // title
            $instructor = $this->instructorRepository->model()->filter($request)->has('user');
            $data['total_instructor'] = $instructor->clone()->count();

            $data['instructor_pending'] = $instructor->clone()->withCount(['user' => function ($query) {
                $query->where('status_id', 3);
            }])->get()->sum('user_count');

            $data['instructor_approved'] = $instructor->clone()->withCount(['user' => function ($query) {
                $query->where('status_id', 4);
            }])->get()->sum('user_count');

            $data['instructors'] = $instructor->clone()->paginate(10); // data
            return view('organization::panel.organization.instructor.instructor_list', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function instructorCreate()
    {
        try {
            $data['url'] = route('organization.instructor.store'); // url
            $data['title'] = ___('organization.Add Instructor'); // title
            @$data['button'] = ___('common.Save');
            $html = view('organization::panel.organization.instructor.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function instructorStore(OrganizationCreate $request)
    {
        try {
            $result = $this->instructorRepository->create($request); // create
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function show($id)
    {
        return view('organization::show');
    }

    public function edit($id)
    {
        return view('organization::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function instructorDelete($id)
    {
        try {
            $result = $this->instructorRepository->delete($id);
            if ($result->original['result']) {
                return back()->with('success', $result->original['message']);
            } else {
                return back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function instructorApprove($id){
        try {
            $instructor = $this->instructorRepository->model()->where('id', $id)->first(); // data
            if (!$instructor) {
                return redirect()->back()->with('danger', ___('alert.instructor_not_found'));
            }
            $result = $this->instructorRepository->approve($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function instructorSuspend($id)
    {
        try {
            $instructor = $this->instructorRepository->model()->where('id', $id)->first(); // data
            if (!$instructor) {
                return redirect()->back()->with('danger', ___('alert.instructor_not_found'));
            }
            $result = $this->instructorRepository->suspend($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function instructorEdit($id, $slug){
        try {
            $data['user_id'] = $id; // data
            $data['title'] = ___('instructor.Edit Instructor'); // title
            $data['instructor'] = $this->instructorRepository->model()->where('user_id', decryptFunction($id))->first();
            return view('organization::panel.organization.instructor.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updateInstructorProfile(InstructorRequest $request, $id)
    {
        try {
            $result = $this->instructorRepository->updateProfile($request, decryptFunction($id));
            if ($result->original['result']) {
                return back()->with('success', $result->original['message']);
            } else {
                return back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {

            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updateInstructorPassword(PasswordRequest $request, $id){
        try {
            $user = User::where('id', decryptFunction($id))->first();
            $result = $this->instructorRepository->updatePassword($request, $user);
            if ($result->original['result']) {
                return back()->with('success', $result->original['message']);
            } else {
                return back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function addInstructorSkill($id){
        try {
            $data['url'] = route('organization.instructor.store.skill', $id); // url
            $data['title'] = ___('course.Skills'); // title
            @$data['button'] = ___('instructor.Save & Update'); // button
            $data['organization'] = $this->instructorRepository->model()->where('user_id', decryptFunction($id))->first();
            $html = view('organization::panel.organization.modal.skill_create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeInstructorSkill(SkillRequest $request, $id){
        try {
            $result = $this->instructorRepository->storeSkill($request, decryptFunction($id));
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
