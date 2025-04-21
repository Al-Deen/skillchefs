<?php

namespace Modules\Organization\Repositories;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Hash;
use Modules\Organization\Entities\InstructorCommission;
use Modules\Organization\Interfaces\InstructorCommissionInterface;

class InstructorCommissionRepository implements InstructorCommissionInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $instructorCommission;

    public function __construct(InstructorCommission $instructorCommission)
    {
        $this->instructorCommission = $instructorCommission;
    }

    public function model()
    {
        return $this->instructorCommission;
    }

    public function store($request){
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            foreach(@$request->instructors as $key => $value) {
                $instructorCommissionModel = new $this->instructorCommission; // create new object of model for store data in database table
                $instructorCommissionModel->organization_id = auth()->user()->id;
                $instructorCommissionModel->user_id = $value;
                $instructorCommissionModel->course_id = $request->course_id;
                $instructorCommissionModel->commission = $request->commissions[$value];
                $instructorCommissionModel->save(); // save data in database table
            }
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Course created successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $course_id){
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            if(@$request->instructors){
                foreach(@$request->instructors as $key => $value) {
                    $instructorCommissionModel = $this->instructorCommission->withTrashed()->where(['course_id' => $course_id, 'user_id' => $value])->first();
                    if(@$instructorCommissionModel){
                        $instructorCommissionModel->user_id = $value;
                        $instructorCommissionModel->commission = $request->commissions[$value];
                        $instructorCommissionModel->deleted_at = null;
                        $instructorCommissionModel->save(); // save data in database table
                    } else{
                        $instructorCommissionModel = new $this->instructorCommission; // create new object of model for store data in database table
                        $instructorCommissionModel->organization_id = auth()->user()->id;
                        $instructorCommissionModel->user_id = $key;
                        $instructorCommissionModel->course_id = $course_id;
                        $instructorCommissionModel->commission = $request->commissions[$value];
                        $instructorCommissionModel->save(); // save data in database table
                    }
                }
            } else{
                $this->instructorCommission->where(['course_id' => $course_id])->delete();
            }
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Course updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

}
