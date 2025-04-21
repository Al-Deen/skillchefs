<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\PasswordUpdateRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Interfaces\UserInterface;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class MyProfileController extends Controller
{
    use ApiReturnFormatTrait;

    private $user;

    public function __construct(UserInterface $userInterface)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')) {
            abort(400);
        }
        $this->user = $userInterface;
    }

    public function profile()
    {
        $data['title'] = 'My Profile';
        return view('backend.my-profile.profile', compact('data'));
    }

    public function edit()
    {
        $data['user'] = $this->user->show(Auth::user()->id);
        $data['title'] = "My Profile Edit";
        return view('backend.my-profile.edit', compact('data'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        try {
            $result = $this->user->profileUpdate($request, Auth::user()->id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function passwordUpdate()
    {
        $data['title'] = 'Password Update';
        return view('backend.my-profile.update_password', compact('data'));
    }

    public function passwordUpdateStore(PasswordUpdateRequest $request)
    {
        if (Hash::check($request->current_password, Auth::user()->password)) {
            $result = $this->user->passwordUpdate($request, Auth::user()->id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } else {
            return back()->with('danger', 'Current password is incorrect');
        }
    }
}
