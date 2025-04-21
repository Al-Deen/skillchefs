<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Interfaces\PermissionInterface;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    private $user;
    private $permission;
    private $role;

    public function __construct(UserInterface $userInterface, PermissionInterface $permissionInterface, RoleInterface $roleInterface)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')) {
            abort(400);
        }
        $this->user = $userInterface;
        $this->permission = $permissionInterface;
        $this->role = $roleInterface;
    }

    public function index()
    {
        $data['users'] = $this->user->model()->with('image')->where('id', '!=', Auth::user()->id)->whereNotIn('role_id', [4, 5])->orderBy('id', 'DESC')->paginate(10);
        $data['title'] = ___('users_roles.users');
        return view('backend.users.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = ___('common.create_user');
        $data['permissions'] = $this->permission->all();
        $data['roles'] = $this->role->model()->whereNotIn('id', [1, 4,5])->get();

        return view('backend.users.create', compact('data'));
    }

    public function store(UserStoreRequest $request)
    {

        try {
            if (env('APP_DEMO')) {
                 return redirect()->back()->with('danger',___('alert.you_can_not_change_in_demo_mode'));
            }
            $result = $this->user->store($request);
            if ($result->original['result']) {
                return redirect()->route('users.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('users.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function edit($id)
    {
        $data['user'] = $this->user->show($id);
        $data['title'] = ___('users_roles.users');
        $data['permissions'] = $this->permission->all();
        $data['roles'] = $this->role->model()->whereNotIn('id', [1, 4,5])->get();
        return view('backend.users.edit', compact('data'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {

            if (env('APP_DEMO')) {
                 return redirect()->back()->with('danger',___('alert.you_can_not_change_in_demo_mode'));
            }

            $result = $this->user->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('users.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('users.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function delete($id)
    {
        try {

            if (env('APP_DEMO')) {
                 return redirect()->back()->with('danger',___('alert.you_can_not_change_in_demo_mode'));
            }
            $result = $this->user->deletes($id);
            if ($result->original['result']) {
                return redirect()->route('roles.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('roles.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('roles.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function changeRole(Request $request)
    {
        $data['role_permissions'] = $this->role->show($request->role_id)->permissions;
        $data['permissions'] = $this->permission->all();
        return view('backend.users.permissions', compact('data'))->render();
    }

    public function status(Request $request)
    {

        if (env('APP_DEMO')) {
                 return redirect()->back()->with('danger',___('alert.you_can_not_change_in_demo_mode'));
        }
        if ($request->type == 'active') {
            $request->merge([
                'status' => 1,
            ]);
            $this->user->status($request);
        }

        if ($request->type == 'inactive') {
            $request->merge([
                'status' => 0,
            ]);
            $this->user->status($request);
        }

        return response()->json(["message" => __("Status update successful")], Response::HTTP_OK);
    }

    public function deletes(Request $request)
    {

        if (env('APP_DEMO')) {
            return redirect()->back()->with('danger',___('alert.you_can_not_change_in_demo_mode'));
        }
        $this->user->deletes($request);

        return response()->json(["message" => __('Delete successful.')], Response::HTTP_OK);

    }
}
