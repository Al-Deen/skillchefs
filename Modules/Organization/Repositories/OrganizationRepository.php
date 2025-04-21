<?php

namespace Modules\Organization\Repositories;

use App\Enums\Role;
use App\Events\AdminEmailVerificationEvent;
use App\Events\UserEmailVerifyEvent;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Organization\Entities\Organization;
use Modules\Organization\Interfaces\OrganizationInterface;

class OrganizationRepository implements OrganizationInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $organizationModel;
    private $countryModel;
    protected $userModel;

    public function __construct(Organization $organizationModel, User $user, Country $countryModel)
    {
        $this->organizationModel = $organizationModel;
        $this->countryModel = $countryModel;
        $this->userModel = $user;
    }

    public function model()
    {
        return $this->organizationModel;
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
            $user = $this->userModel;
            $user->name = $request->name;
            $user->username = Str::slug($request->name);
            $user->email = $request->email;
            $user->token = Str::random(30);
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->role_id = 6;
            $user->status_id = 4;
            $user->save();

            $request->session()->put('password', $request->password); // store user id in session for store data in database table

            $organization = $this->organizationModel; // create new object of model for store data in database table
            $organization->user_id = $user->id;
            $organization->save();

            $alert = ___('alert.Please check email to verify this account.');
            try {
                event(new AdminEmailVerificationEvent($user));
            } catch (\Throwable $th) {
                $alert = ___('alert.Organization create but please configure SMTP to send email correctly');
            }
            $request->session()->forget('password'); // remove user id from session

            DB::commit(); // commit database transaction
            return $this->responseWithSuccess($alert, [], 200);
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
            $organization = $this->model()->where('id', $id)->first();
            $user = $organization->user;
            $user->status_id = 5;
            $user->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Organization suspended successfully'), [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function reActivate($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $organization = $this->model()->where('id', $id)->first();
            $user = $organization->user;
            $user->status_id = 4;
            $user->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Organization re-activate successfully'), [], 200);
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
            $organization = $this->model()->where('id', $id)->first();
            $user = $organization->user;
            $user->status_id = 4;
            $user->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Organization approved successfully'), [], 200);
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
            $organizationModel = $this->organizationModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            $organizationModel->date_of_birth = date_db_format($request->date_of_birth);
            $organizationModel->gender = $request->gender;
            $organizationModel->address = $request->address;
            $organizationModel->country_id = $request->country_id;
            $organizationModel->about_me = $request->about_me;
            $organizationModel->designation = $request->designation;
            $organizationModel->save(); // save data in database table
            $user = $organizationModel->user;

            if ($request->hasFile('profile_image')) {
                if(Storage::exists('public/' . $user->image->original)){
                    Storage::delete('public/' . $user->image->original);
                }
                $upload = $this->uploadFile($request->profile_image, 'organization/profile', [], $user->image_id, 'image'); // upload file and resize image 35x35
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

    public function delete($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $organization = $this->model()->find($id);
            $organization->user->delete();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Organization deleted successfully.')); // return success response

        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    // start skills
    public function storeSkill($request, $id)
    {

        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $organizationModel = $this->organizationModel->where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$organizationModel) {
                $organizationModel = new $this->organizationModel;
                $organizationModel->user_id = $id;
                $organizationModel->save();
            }
            $organizationModel->skills = json_decode($request->skills);
            $organizationModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Organization skills added successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $organization, $slug)
    {
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            if ($slug == 'general') {
                return $this->updateProfile($request, $organization->user_id);
            } elseif ($slug == 'security') {
                return $this->updatePassword($request, $organization->user);
            } else {
                return $this->responseWithError(___('alert.Invalid request.'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
