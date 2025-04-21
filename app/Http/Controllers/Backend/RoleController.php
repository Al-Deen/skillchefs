<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;

class RoleController extends Controller
{
    private $role;
    private $permission;

    public function __construct(RoleInterface $role, PermissionInterface $permission)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')) {
            abort(400);
        }
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index()
    {
        $data['roles'] = $this->role->getAll();
        $data['title'] = ___('common.roles');
        return view('backend.roles.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = ___('common.create_role');
        $data['permissions'] = $this->permission->all();
        return view('backend.roles.create', compact('data'));
    }

    public function store(RoleStoreRequest $request)
    {
        try {

            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger', ___('alert.you_can_not_change_in_demo_mode'));
            }
            $result = $this->role->store($request);
            if ($result->original['result']) {
                return redirect()->route('roles.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function edit($id)
    {
        $data['role'] = $this->role->show($id);
        $data['title'] = ___('common.roles');
        $data['permissions'] = $this->permission->all();
        return view('backend.roles.edit', compact('data'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        try {

            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger', ___('alert.you_can_not_change_in_demo_mode'));
            }

            $result = $this->role->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('roles.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function delete($id)
    {

        try {

            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger', ___('alert.you_can_not_change_in_demo_mode'));
            }
            $result = $this->role->destroy($id);
            if ($result->original['result']) {
                return redirect()->route('roles.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('roles.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('roles.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
