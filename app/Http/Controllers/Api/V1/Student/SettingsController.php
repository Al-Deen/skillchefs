<?php

namespace App\Http\Controllers\Api\V1\Student;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Student\Http\Requests\SkillRequest;
use Modules\Student\Interfaces\StudentInterface;
use Modules\Student\Http\Requests\StudentRequest;
use Modules\Student\Http\Requests\PasswordRequest;
use Modules\Student\Http\Requests\InstituteRequest;

class SettingsController extends Controller
{

    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $studentRepository;


    public function __construct(StudentInterface $studentRepository) {
        $this->studentRepository          = $studentRepository;
    }


    // start update password
    public function updateProfile(StudentRequest $request)
    {

        try {
            $result = $this->studentRepository->updateProfile($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function updatePassword(PasswordRequest $request)
    {

        try {
            $result = $this->studentRepository->updatePassword($request);
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
