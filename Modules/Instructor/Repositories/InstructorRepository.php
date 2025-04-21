<?php

namespace Modules\Instructor\Repositories;

use App\Enums\Role;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Events\UserEmailVerifyEvent;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\SignupOTPSenderTrait;
use Illuminate\Support\Facades\Hash;
use App\Events\AdminEmailVerificationEvent;
use Modules\Instructor\Entities\Instructor;
use Modules\Instructor\Interfaces\InstructorInterface;

class InstructorRepository implements InstructorInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, SignupOTPSenderTrait;

    private $instructorModel;
    private $countryModel;
    private $instituteModel;
    private $experienceModel;
    protected $userModel;

    public function __construct(Instructor $instructorModel, User $user, Country $countryModel)
    {
        $this->instructorModel = $instructorModel;
        $this->countryModel = $countryModel;
        $this->userModel = $user;
    }

    public function model()
    {
        return $this->instructorModel;
    }

    public function create($request)
    {
        if (env('APP_DEMO')) {
            return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
        }

        DB::beginTransaction(); // start database transaction
        try {
            $user = $this->userModel->where('email', $request->email)->first();
            if ($user) {
                return $this->responseWithError(___('alert.Email already exists'), [], 400);
            }
            $user = $this->userModel;
            $user->name = $request->name;
            $user->username = Str::slug($request->name);
            $user->email = $request->email;
            $user->token = Str::random(30);
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->role_id = Role::INSTRUCTOR;
            if (auth()->user()->role_id != 5) {
                $user->status_id = 4;
                $user->email_verified_at = now();
                $user->phone_verified_at = now();
            }
            $user->save();

            $request->session()->put('password', $request->password); // store user id in session for store data in database table (institute, experience)

            $instructor = $this->instructorModel; // create new object of model for store data in database table
            $instructor->user_id = $user->id;
            $instructor->save();

            $alert = ___('alert.Please check email to verify this account.');
            try {
                event(new AdminEmailVerificationEvent($user));
            } catch (\Throwable $th) {
                $alert = ___('alert.Instructor create but please configure SMTP to send email correctly');
            }
            $request->session()->forget('password'); // remove user id from session

            DB::commit(); // commit database transaction
            return $this->responseWithSuccess($alert, [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }

    }
    public function store($request)
    {
        if (env('APP_DEMO')) {
            return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
        }

        DB::beginTransaction(); // start database transaction
        try {
            $user = $this->userModel->where('email', $request->email)->first();
            if ($user) {
                return $this->responseWithError(___('alert.Email already exists'), [], 400);
            }
            $user_name = preg_replace('/[^A-Za-z0-9]/', '', Str::slug($request->name, '-'));
            $user = $this->userModel;
            $user->name = $request->name;
            $user->username = $user_name . '-' . Str::random(5);
            $user->email = $request->email;
            //$user->token = Str::random(30);
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->role_id = Role::INSTRUCTOR;

            // email otp send
            $otpVerificationStatus = setting('instructor_otp_verification');
            if($otpVerificationStatus === "1" || $otpVerificationStatus === "3"){
                try {
                    event(new UserEmailVerifyEvent($user));
                } catch (\Throwable $th) {
                    $alert = ___('alert.Instructor create but please configure SMTP to send email correctly');
                }
                $alert = ___('alert.Please check your email to verify your account.');
            }
            // sms otp send
            if($otpVerificationStatus === "2" || $otpVerificationStatus === "3"){
                $user->token = mt_rand(1111,9999);
                $user->save();
                $this->SendSignupOTP(___('alert.Your_OTP_Code_is') . $user->token . ___('This_Code_will_expire_in_15_minutes'), $request->phone);
                $alert = ___('alert.Please check your mobile to verify phone number.');
            }
            // no verification
            if($otpVerificationStatus === "0"){
                $user->email_verified_at = now();
                $user->phone_verified_at = now();
                $user->save();
            }

            $user->save();

            $instructor = $this->instructorModel; // create new object of model for store data in database table
            $instructor->user_id = $user->id;
            $instructor->save();
           

            DB::commit(); // commit database transaction
            return $this->responseWithSuccess($alert, [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }

    }
    public function suspend($id)
    {
        if (env('APP_DEMO')) {
            return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
        }
        DB::beginTransaction(); // start database transaction
        try {
            $instructor = $this->model()->where('id', $id)->first();
            $user = $instructor->user;
            $user->status_id = 5;
            $user->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor suspended successfully'), [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    public function reActivate($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $instructor = $this->model()->where('id', $id)->first();
            $user = $instructor->user;
            $user->status_id = 4;
            $user->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor re-activate successfully'), [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    public function approve($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $instructor = $this->model()->where('id', $id)->first();
            $user = $instructor->user;
            $user->status_id = 4;
            $user->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor approved successfully'), [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function updateProfile($request, $id)
    {
        DB::beginTransaction(); // start database transaction

        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $instructor = $this->instructorModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            $instructor->date_of_birth = date_db_format($request->date_of_birth);
            $instructor->gender = $request->gender;
            $instructor->address = $request->address;
            $instructor->country_id = $request->country_id;
            $instructor->about_me = $request->about_me;
            $instructor->designation = $request->designation;
            $instructor->save(); // save data in database table

            $user = $instructor->user;

            if ($request->hasFile('profile_image')) {
                $upload = $this->uploadFile($request->profile_image, 'instructor/profile', [], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $user->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Profile updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function updatePassword($request, $user)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            if (!Hash::check($request->old_password, $user->password)) {
                return $this->responseWithError(___('alert.Old password does not match.'), [], 400);
            }
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Password updated successfully.')); // return success response
        } catch (\Throwable $th) {

            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    public function updateCommission($request, $user)
    {

        DB::beginTransaction(); // start database transaction

        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            if (!Hash::check($request->password, auth()->user()->password)) {
                return $this->responseWithError(___('alert.password does not match.'), [], 400);
            }
            $instructorModel = $this->instructorModel->where('user_id', $user->id)->first(); // create new object of model for store data in database table
            if (!@$instructorModel) {
                $instructorModel = new $this->instructorModel;
                $instructorModel->user_id = $user->id;
                $instructorModel->save();
            }
            $instructorModel->commission = $request->commission;
            $instructorModel->save();
            $instructorModel->user->update(["event_commission" => $request->event_commission]);
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Commission updated successfully.')); // return success response
        } catch (\Throwable $th) {

            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    // start institute
    public function addInstitute($request, $id)
    {

        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $instructorModel = $this->instructorModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$instructorModel) {
                $instructorModel = new $this->instructorModel;
                $instructorModel->user_id = $id;
                $instructorModel->save();
            }

            $educationArr = [];
            $educations = $instructorModel->education ?? [];
            if ($request->name) {
                $educationArr = [
                    'name' => $request->name,
                    'program' => $request->program,
                    'degree' => $request->degree,
                    'current' => $request->current ? 1 : 0,
                    'start_date' => $request->start_date,
                    'end_date' => $request->current ? null : $request->end_date,
                    'description' => $request->description,
                ];
                array_push($educations, $educationArr);
            }
            $instructorModel->education = $educations;
            $instructorModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor institute added successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function updateInstitute($request, $key, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $instructorModel = $this->instructorModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$instructorModel) {
                return $this->responseWithError(___('alert.Instructor institute not found.'), [], 400);
            }

            $educations = $instructorModel->education ?? [];
            if ($request->name) {
                $educations[$key] = [
                    'name' => $request->name,
                    'program' => $request->program,
                    'degree' => $request->degree,
                    'current' => $request->current ? 1 : 0,
                    'start_date' => $request->start_date,
                    'end_date' => $request->current ? null : $request->end_date,
                    'description' => $request->description,
                ];
            }
            $instructorModel->education = $educations;
            $instructorModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor institute updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function deleteInstitute($key, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $instructorModel = $this->instructorModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$instructorModel) {
                return $this->responseWithError(___('alert.Instructor institute not found.'), [], 400);
            }

            $educations = $instructorModel->education ?? [];
            if (isset($educations[$key])) {
                unset($educations[$key]);
            }
            $instructorModel->education = $educations;
            $instructorModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor institute deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    // end institute
    // start experience
    public function addExperience($request, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $instructorModel = $this->instructorModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$instructorModel) {
                $instructorModel = new $this->instructorModel;
                $instructorModel->user_id = $id;
                $instructorModel->save();
            }

            $experienceArr = [];
            $experiences = $instructorModel->experience ?? [];
            if ($request->name) {
                $experienceArr = [
                    'title' => $request->title,
                    'name' => $request->name,
                    'employee_type' => $request->employee_type,
                    'location' => $request->location,
                    'location_type' => $request->location_type,
                    'current' => $request->current ? 1 : 0,
                    'start_date' => $request->start_date,
                    'end_date' => $request->current ? null : $request->end_date,
                    'description' => $request->description,
                ];
                array_push($experiences, $experienceArr);
            }
            $instructorModel->experience = $experiences;
            $instructorModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor experience added successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function updateExperience($request, $key, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $instructorModel = $this->instructorModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$instructorModel) {
                return $this->responseWithError(___('alert.Instructor experience not found.'), [], 400); // return error response
            }

            $experiences = $instructorModel->experience ?? [];
            if ($request->name) {
                $experiences[$key] = [
                    'title' => $request->title,
                    'name' => $request->name,
                    'employee_type' => $request->employee_type,
                    'location' => $request->location,
                    'location_type' => $request->location_type,
                    'current' => $request->current ? 1 : 0,
                    'start_date' => $request->start_date,
                    'end_date' => $request->current ? null : $request->end_date,
                    'description' => $request->description,
                ];
            }
            $instructorModel->experience = $experiences;
            $instructorModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor experience updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function deleteExperience($key, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $instructorModel = $this->instructorModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$instructorModel) {
                return $this->responseWithError(___('alert.Instructor experience not found.'), [], 400); // return error response
            }

            $experiences = $instructorModel->experience ?? [];
            if (isset($experiences[$key])) {
                unset($experiences[$key]);
            }
            $instructorModel->experience = $experiences;
            $instructorModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor experience Deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    // end experience

    // start skills
    public function storeSkill($request, $id)
    {

        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $instructorModel = $this->instructorModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$instructorModel) {
                $instructorModel = new $this->instructorModel;
                $instructorModel->user_id = $id;
                $instructorModel->save();
            }
            $instructorModel->skills = json_decode($request->skills);
            $instructorModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor skills added successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    // Using this function at front end

    public function update($request, $instructor, $slug)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            if ($slug == 'general') {
                return $this->updateProfile($request, $instructor->user_id);
            } elseif ($slug == 'security') {
                return $this->updatePassword($request, $instructor->user);
            } elseif ($slug == 'commission') {
                return $this->updateCommission($request, $instructor->user);
            } else {
                return $this->responseWithError(___('alert.Invalid request.'), [], 400); // return error response
            }

        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    // delete instructor
    public function delete($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $instructor = $this->model()->find($id);
            $instructor->user->delete();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Instructor deleted successfully.')); // return success response

        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
