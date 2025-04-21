<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Role;
use App\Models\User;
use App\Interfaces\CartInterface;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartInterface
{
    use CommonHelperTrait, ApiReturnFormatTrait;
    private $model;
    private $course;

    public function __construct(Cart $cartModel)
    {
        $this->model = $cartModel;
    }

    public function model()
    {
        return $this->model;
    }

    // start store data in cart table
    public function store($request)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $courseModel                     = new $this->model; // create new object of model for store data in database table
            $courseModel->course_id          = $request->course_id;
            $courseModel->user_id            = Auth::user()->id;
            $courseModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Course added to cart successfully.'),$courseModel); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    // end store data in cart table

    // start update data in cart table
    public function update($request, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $courseModel                     = new $this->model; // create new object of model for store data in database table
            $courseModel->course_id          = $request->course_id;
            $courseModel->user_id            = Auth::user()->id;
            $courseModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Course updated to cart successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    // end update data in cart table

    // start delete data from cart table
    public function destroy($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $courseModel = $this->model->find($id); // find data from database table
            $courseModel->delete(); // delete data from database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Course deleted to cart successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
