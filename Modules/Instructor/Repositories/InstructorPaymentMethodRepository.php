<?php

namespace Modules\Instructor\Repositories;

use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Course\Entities\Course;
use Modules\Instructor\Entities\InstructorPaymentMethod;
use Modules\Instructor\Interfaces\InstructorPaymentMethodInterface;

class InstructorPaymentMethodRepository implements InstructorPaymentMethodInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;
    private $courseModel;
    protected $userModel;

    public function __construct(InstructorPaymentMethod $paymentMethodModel, Course $courseModel, User $userModel)
    {
        $this->model = $paymentMethodModel;
        $this->courseModel = $courseModel;
        $this->userModel = $userModel;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function model()
    {
        return $this->model;
    }

    public function filter($filter = null)
    {
        $model = $this->model;
        if (@$filter) {
            $model = $this->model->where($filter);
        }
        return $model;
    }

    public function store($request)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $payoutModel = $this->model->where('payment_method_id', $request->payment_method)->where('user_id', auth()->user()->id)->first();
            if ($payoutModel) {
                return $this->responseWithError(___('alert.Payment method already exists.'), [], 400);
            } else {
                $payoutModel = $this->model;
            }
            $payoutModel->user_id = auth()->user()->id;
            if (!Hash::check($request->password, auth()->user()->password)) {
                return $this->responseWithError(___('alert.Password does not match.'), [], 400);
            }
            if ($request->is_default == 0 && $this->model->where('user_id', auth()->user()->id)->where('is_default', 1)->count() == 0) {
                return $this->responseWithError(___('alert.At least one payment account has been set as the default.'), [], 400);
            }
            $payoutModel->payment_method_id = $request->payment_method;
            $credentials = [];
            if ($request->payment_method == 1) {
                $credentials['STRIPE_KEY'] = trim($request->stripe_key);
                $credentials['STRIPE_SECRET'] = trim($request->stripe_secret);
            } else if ($request->payment_method == 2) {
                $credentials['SSLCZ_STORE_ID'] = trim($request->store_id);
                $credentials['SSLCZ_STORE_PASSWD'] = trim($request->store_password);
            }
            $payoutModel->credentials = ($credentials);
            if ($request->is_default == 1) {
                $this->model->where('user_id', auth()->user()->id)->update(['is_default' => 0]);
                $payoutModel->is_default = 1;
            } else {
                $payoutModel->is_default = 0;
            }
            $payoutModel->is_default = $request->is_default ? 1 : 0;
            $payoutModel->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Payment Method added successfully.'), [], 200); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $payoutModel = $this->model->where('id', $id)->where('user_id', auth()->user()->id)->first();
            if (!$payoutModel) {
                return $this->responseWithError(___('alert.Payment Method not found.'), [], 400); // return error response
            }
            if (!Hash::check($request->password, auth()->user()->password)) {
                return $this->responseWithError(___('alert.Password does not match.'), [], 400);
            }
            if ($request->is_default == 0 && $this->model->where('user_id', auth()->user()->id)->where('is_default', 1)->where('id', '!=', $id)->count() == 0) {
                return $this->responseWithError(___('alert.At least one payment account has been set as the default.'), [], 400);
            }
            $payoutModel->payment_method_id = $request->payment_method;
            $credentials = [];
            if ($request->payment_method == 1) {
                $credentials['STRIPE_KEY'] = trim($request->stripe_key);
                $credentials['STRIPE_SECRET'] = trim($request->stripe_secret);
            } else if ($request->payment_method == 2) {
                $credentials['SSLCZ_STORE_ID'] = trim($request->store_id);
                $credentials['SSLCZ_STORE_PASSWD'] = trim($request->store_password);
            }
            $payoutModel->credentials = ($credentials);
            if ($request->is_default == 1) {
                $this->model->where('user_id', auth()->user()->id)->update(['is_default' => 0]);
                $payoutModel->is_default = 1;
            } else {
                $payoutModel->is_default = 0;
            }
            $payoutModel->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Payment Method updated successfully.'), [], 200); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $payoutModel = $this->model->find($id);
            $payoutModel->delete();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Payment Method deleted successfully.'), [], 200); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
