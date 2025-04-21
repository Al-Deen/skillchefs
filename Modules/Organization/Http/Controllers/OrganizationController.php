<?php

namespace Modules\Organization\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Organization\Http\Requests\SkillRequest;
use Modules\Organization\Http\Requests\AdminOrganizationRequest;
use Modules\Organization\Http\Requests\OrganizationCreate;
use Modules\Organization\Interfaces\OrganizationInterface;
class OrganizationController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $organization;

    public function __construct(OrganizationInterface $organizationInterface)
    {
        $this->organization = $organizationInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['organizations'] = $this->organization->model()->active()->search($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('organization.Organization List'); // title
            return view('organization::panel.organization.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try {
            $data['title'] = ___('organization.Create Organization'); // title
            return view('organization::panel.organization.create', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(OrganizationCreate $request)
    {
        try {
            $result = $this->organization->create($request);
            if ($result->original['result']) {
                return redirect()->route('organization.admin.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('organization::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id, $slug)
    {
        try {
            $data['organization'] = $this->organization->model()->where('id', $id)->first(); // data
            if (!$data['organization']) {
                return redirect()->back()->with('danger', ___('alert.organization_not_found'));
            }
            $data['url'] = route('organization.admin.update', [$data['organization']->id, $slug]); // url']
            $data['title'] = ___('organization.Update Organization'); // title
            return view('organization::panel.organization.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdminOrganizationRequest $request, $id, $slug)
    {
        try {
            $organization = $this->organization->model()->where('id', $id)->first(); // data
            if (!$organization) {
                return redirect()->back()->with('danger', ___('alert.instructor_not_found'));
            }
            $result = $this->organization->update($request, $organization, $slug);
            if ($result->original['result']) {
                return redirect()->route('organization.admin.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $result = $this->organization->delete($id);
            if ($result->original['result']) {
                return back()->with('success', $result->original['message']);
            } else {
                return back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function requestIndex(Request $request){
        try {
            $data['organizations'] = $this->organization->model()->pending()->search($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('organization.Organization Request List'); // title
            return view('organization::panel.organization.request', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function suspendIndex(Request $request)
    {
        try {
            $data['organizations'] = $this->organization->model()->suspended()->search($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('organization.Organization Suspended List'); // title
            return view('organization::panel.organization.suspend', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function approve($id)
    {
        try {
            $organization = $this->organization->model()->where('id', $id)->first(); // data
            if (!$organization) {
                return redirect()->back()->with('danger', ___('alert.organization_not_found'));
            }
            $result = $this->organization->approve($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function reActivate($id)
    {
        try {
            $organization = $this->organization->model()->where('id', $id)->first(); // data
            if (!$organization) {
                return redirect()->back()->with('danger', ___('alert.organization_not_found'));
            }
            $result = $this->organization->reActivate($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function suspend($id)
    {
        try {
            $organization = $this->organization->model()->where('id', $id)->first(); // data
            if (!$organization) {
                return redirect()->back()->with('danger', ___('alert.organization_not_found'));
            }
            $result = $this->organization->suspend($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /* skills */
    public function addSkill(Request $request, $id)
    {
        try {
            $data['url'] = route('organization.admin.store.skill', $id); // url
            $data['title'] = ___('course.Skills'); // title
            @$data['button'] = ___('organization.Save & Update'); // button
            $data['organization'] = $this->organization->model()->where('user_id', $id)->first();
            $html = view('organization::panel.organization.modal.skill_edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeSkill(SkillRequest $request, $id)
    {
        try {
            $result = $this->organization->storeSkill($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    /* skills end */

    public function login($id)
    {
        try {
            $data['organization'] = $this->organization->model()->where('id', $id)->first(); // data
            if (!$data['organization']) {
                return redirect()->back()->with('danger', ___('alert.organization_not_found'));
            }
            Auth::loginUsingId($data['organization']->user_id);
            return redirect()->route('organization.dashboard');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
