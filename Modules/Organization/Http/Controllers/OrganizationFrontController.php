<?php

namespace Modules\Organization\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Organization\Interfaces\OrganizationInterface;
use App\Http\Requests\frontend\instructor\InstructorRegistration;

class OrganizationFrontController extends Controller
{

    use ApiReturnFormatTrait;

    // constructor injection
    protected $organizationInterface;
    protected $courseInterface;

    public function __construct(OrganizationInterface $organizationInterface, CourseInterface $courseInterface)
    {
        $this->organizationInterface = $organizationInterface;
        $this->courseInterface = $courseInterface;
    }

    public function details($name, $id)
    {
        try {
            $data['title'] = ___('frontend.Organization Details'); // title
            $data['organization'] = $this->organizationInterface->model()->where('user_id', $id)->first();
            if (!$data['organization']) {
                return redirect()->route('home')->with('danger', ___('alert.Instructor_not_found'));
            }
            $data['courses'] = $this->courseInterface->model()->where('created_by',  $data['organization']->user->id)->active()->visible()->paginate(4);
            return view('organization::panel.organization.frontend.details', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function becomeOrganization()
    {
        try {
            $data['title']      = ___('frontend.Become A Organization'); // title
            return view('frontend.auth.become_organization', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    
    public function signUp(InstructorRegistration $request)
    {
        try {
            $result = $this->organizationInterface->create($request);
            if ($result->original['result']) {
                return redirect()->route('frontend.signIn')->with('email_verify', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
