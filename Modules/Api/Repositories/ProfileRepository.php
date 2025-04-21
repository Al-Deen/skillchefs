<?php

namespace Modules\Api\Repositories;

use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Hash;
use Modules\Student\Entities\Student;
use Modules\Api\Interfaces\ProfileInterface;


class ProfileRepository implements ProfileInterface
{

    use ApiReturnFormatTrait, FileUploadTrait;

    protected $userModel;
    protected $studentModel;

    public function __construct(User $userModel, Student $studentModel) {
        $this->userModel = $userModel;
        $this->studentModel = $studentModel;
    }

    public function model(){
        return $this->studentModel;
    }

    public function updateProfile($request){
        DB::beginTransaction();
        try{
            $student = $this->model()->where('user_id', auth()->id())->first();
            $student->date_of_birth = date_db_format($request->date_of_birth);
            $student->update();

            $user = $student->user;

            if ($request->hasFile('profile_image')) {
                $upload = $this->uploadFile($request->profile_image, 'student/profile', [], '', 'image'); // upload file and resize image 35x35
                $user->image_id = $upload['upload_id'];
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->update();

            DB::commit();

            return $this->responseWithSuccess(___('alert.Profile updated successfully.'));
        }catch(\Throwable $th){
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400);
        }
    }

    public function updatePassword($request){
        DB::beginTransaction();
        try {
            $user = $this->userModel->where('id', auth()->id())->first();

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
}
