<?php

namespace Modules\Student\Repositories;

use App\Enums\Role;
use App\Events\AdminEmailVerificationEvent;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Student\Entities\Student;
use Modules\Student\Interfaces\StudentInterface;

class StudentRepository implements StudentInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $studentModel;
    private $countryModel;
    private $stateModel;
    private $cityModel;
    private $userModel;

    public function __construct(
        Student $studentModel,
        Country $countryModel,
        State $stateModel,
        City $cityModel,
        User $userModel

    ) {
        $this->studentModel = $studentModel;
        $this->countryModel = $countryModel;
        $this->stateModel = $stateModel;
        $this->cityModel = $cityModel;
        $this->userModel = $userModel;
    }

    public function model()
    {
        return $this->studentModel;
    }

    public function create($request)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $user = $this->userModel->where('email', $request->email)->first();
            if ($user) {
                return $this->responseWithError(___('alert.Email already exists'), [], 400);
            }
            $user_name = preg_replace('/[^A-Za-z0-9]/', '', Str::slug($request->name, '-'));
            $user = $this->userModel;
            $user->name = $request->name;
            $user->username = $user_name . '-' . Str::random(5);
            $user->email = $request->email;
            $user->token = Str::random(30);
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->role_id = Role::STUDENT;
            if (auth()->user()->role_id != 5) {
                $user->status_id = 4;
                $user->email_verified_at = now();
                $user->phone_verified_at = now();
            }
            $user->save();

            $request->session()->put('password', $request->password); // store user id in session for store data in database table (institute, experience)

            $instructor = $this->studentModel; // create new object of model for store data in database table
            $instructor->user_id = $user->id;
            $instructor->save();

            event(new AdminEmailVerificationEvent($user));

            $request->session()->forget('password'); // remove user id from session

            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Please check email to verify this account.'), [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }

    }

    public function suspend($id)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $instructor = $this->model()->where('id', $id)->first();
            $user = $instructor->user;
            $user->status_id = 5;
            $user->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Student suspended successfully'), [], 200);
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
            return $this->responseWithSuccess(___('alert.Student re-activate successfully'), [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    public function approve($id)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $instructor = $this->model()->where('id', $id)->first();
            $user = $instructor->user;
            $user->status_id = 4;
            $user->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Student approved successfully'), [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

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
            } else {
                return $this->responseWithError(___('alert.Invalid request.'), [], 400); // return error response
            }

        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function updateProfile($request, $id)
    {

        DB::beginTransaction(); // start database transaction

        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $student = $this->studentModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            $student->date_of_birth = date_db_format($request->date_of_birth);
            $student->gender = $request->gender;
            $student->address = $request->address;
            $student->country_id = $request->country_id;
            $student->about_me = $request->about_me;
            $student->designation = $request->designation;
            $student->save(); // save data in database table

            $user = $student->user;

            if ($request->hasFile('profile_image')) {
                $upload = $this->uploadFile($request->profile_image, 'student/profile', [], '', 'image'); // upload file and resize image 35x35
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
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function updatePassword($request, $user)
    {

        DB::beginTransaction(); // start database transaction

        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
           if ($user->password){
            if (!Hash::check($request->old_password, $user->password)) {
                return $this->responseWithError(___('alert.Old password does not match.'), [], 400);
            }
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

    // start institute
    public function addInstitute($request, $id)
    {

        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $studentModel = $this->studentModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$studentModel) {
                $studentModel = new $this->studentModel;
                $studentModel->user_id = $id;
                $studentModel->save();
            }

            $educationArr = [];
            $educations = $studentModel->education ?? [];
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
            $studentModel->education = $educations;
            $studentModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Student institute added successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function updateInstitute($request, $key, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $studentModel = $this->studentModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$studentModel) {
                return $this->responseWithError(___('alert.Student not found.'), [], 400);
            }

            $educations = $studentModel->education ?? [];
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
            $studentModel->education = $educations;
            $studentModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Student institute updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function deleteInstitute($key, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $studentModel = $this->studentModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$studentModel) {
                return $this->responseWithError(___('alert.Student not found.'), [], 400);
            }

            $educations = $studentModel->education ?? [];
            if (isset($educations[$key])) {
                unset($educations[$key]);
            }
            $studentModel->education = $educations;
            $studentModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Student institute deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
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

            $studentModel = $this->studentModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$studentModel) {
                $studentModel = new $this->studentModel;
                $studentModel->user_id = $id;
                $studentModel->save();
            }

            $experienceArr = [];
            $experiences = $studentModel->experience ?? [];
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
            $studentModel->experience = $experiences;
            $studentModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Student experience added successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function updateExperience($request, $key, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $studentModel = $this->studentModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$studentModel) {
                return $this->responseWithError(___('alert.Student not found.'), [], 400);
            }

            $experiences = $studentModel->experience ?? [];
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
            $studentModel->experience = $experiences;
            $studentModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Student experience updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function deleteExperience($key, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $studentModel = $this->studentModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$studentModel) {
                return $this->responseWithError(___('alert.Student not found.'), [], 400);
            }

            $experiences = $studentModel->experience ?? [];
            if (isset($experiences[$key])) {
                unset($experiences[$key]);
            }
            $studentModel->experience = $experiences;
            $studentModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Student experience Deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
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

            $studentModel = $this->studentModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$studentModel) {
                return $this->responseWithError(___('alert.Student not found.'), [], 400);
            }
            $studentModel->skills = json_decode($request->skills);
            $studentModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Student skills added successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
