<?php

namespace Modules\Api\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\ApiReturnFormatTrait;
use Modules\Api\Interfaces\ProfileInterface;
use Modules\Student\Http\Requests\StudentRequest;
use Modules\Student\Http\Requests\PasswordRequest;
use Modules\Api\Http\Requests\ProfileUpdateRequest;
use Modules\Student\Http\Requests\InstituteRequest;
use Modules\Api\Http\Requests\ProfileImageUpdateRequest;

class ProfileController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $profile;
    protected $user;

    public function __construct(ProfileInterface $profileInterface, UserInterface $userInterface) {
        $this->profile          = $profileInterface;
        $this->user             = $userInterface;
    }


    // start update profile
    public function updateProfile(ProfileUpdateRequest $request)
    {
        try {
            $result = $this->profile->updateProfile($request);

            $user   = new UserResource($this->user->model()->where('id', auth()->id())->first());
                $data['user']   = $user;

            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $data);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    // end update profile

    // start update password
    public function updatePassword(PasswordRequest $request)
    {
        try {
            $result = $this->profile->updatePassword($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    // end update password

}

