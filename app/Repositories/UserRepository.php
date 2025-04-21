<?php

namespace App\Repositories;

use App\Http\Requests\Profile\PasswordUpdateRequest;
use App\Interfaces\UserInterface;
use App\Models\Role;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    use CommonHelperTrait, ApiReturnFormatTrait, FileUploadTrait;

    private User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function model()
    {
        return $this->model;
    }

    public function index($request)
    {
        $data = $this->model->query()->with('image', 'designation');

        $where = array();

        if ($request->search) {
            $where[] = ['name', 'like', '%' . $request->search . '%'];
        }

        if ($request->from && $request->to) {
            $data = $data->whereBetween('created_at', [Carbon::parse($request->from), Carbon::parse($request->to)->endOfDay()]);
        }

        if ($request->designation) {
            $data = $data->whereIn('designation_id', $request->designation);
        }

        $data = $data
            ->where($where)
            ->orderBy('id', 'DESC')
            ->paginate($request->show ?? 10);

        return $data;
    }

    public function status($request)
    {
        return $this->model->whereIn('id', $request->ids)->update(['status' => $request->status]);
    }

    public function deletes($request)
    {
        return $this->model->destroy((array) $request->ids);
    }

    public function getAll()
    {
        return User::query()->with('image')->where('id', '!=', Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
    }

    public function store($request)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $userStore = new $this->model;
            $userStore->name = $request->name;
            $userStore->role_id = $request->role;
            $userStore->email = $request->email;
            $userStore->phone = $request->phone;
            $userStore->password = Hash::make($request->password);
            $userStore->permissions = $request->permissions;
            $userStore->status = $request->status;

            if ($request->hasFile('image')) {
                $upload = $this->uploadFile($request->image, 'backend/uploads/users/profile_', [], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $userStore->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            // for verified
            $userStore->email_verified_at = now();
            $userStore->token = null;

            $userStore->save();
            return $this->responseWithSuccess(___('alert.user_created_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.user_created_failed'));
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $userUpdate = $this->model->findOrfail($id);
            $userUpdate->name = $request->name;
            $userUpdate->role_id = $request->role;
            $userUpdate->email = $request->email;
            $userUpdate->phone = $request->phone;
            if ($request->password) {
                $userUpdate->password = Hash::make($request->password);
            }
            $userUpdate->permissions = $request->permissions;
            $userUpdate->status = $request->status;

            if ($request->hasFile('image')) {
                $upload = $this->uploadFile($request->image, 'backend/uploads/users/profile_', [], $userUpdate->image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $userUpdate->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $userUpdate->update();
            return $this->responseWithSuccess(___('alert.user_updated_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function profileUpdate($request, $id)
    {
        DB::beginTransaction();
        try {
            $userUpdate = $this->model->findOrfail($id);
            $userUpdate->name = $request->name;
            $userUpdate->phone = $request->phone;
            $userUpdate->date_of_birth = $request->date_of_birth;

            if ($request->hasFile('image')) {
                $upload = $this->uploadFile($request->image, 'backend/uploads/users/profile_', [], $userUpdate->image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $userUpdate->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $userUpdate->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.User updated successfully'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $user = $this->model->find($id);
            $upload = $this->deleteFile($user->image_id, 'delete'); // delete file from storage
            if (!$upload['status']) {
                return $this->responseWithError($upload['message'], [], 400); // return error response
            }
            $user->delete();
            return $this->responseWithSuccess(___('alert.User_deleted_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function passwordUpdate(PasswordUpdateRequest $request, $id)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $userUpdate = $this->model->findOrfail($id);
            $userUpdate->password = Hash::make($request->password);
            $userUpdate->save();
            return $this->responseWithSuccess(___('alert.User password update successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    // instructor start

}
