<?php

namespace Modules\Payment\Repositories;

use App\Models\User;
use App\Traits\FileUploadTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use App\Traits\ApiReturnFormatTrait;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Interfaces\PaymentInterface;
use Modules\PaynetGateway\Http\Controllers\PaynetGatewayController;
// use Modules\PaynetGateway\Http\Controllers\PaynetGatewayController;

class PaymentRepository implements PaymentInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;
    private $courseModel;
    protected $userModel;

    public function __construct(PaymentMethod $paymentModel, Course $courseModel, User $userModel)
    {
        $this->model = $paymentModel;
        $this->courseModel = $courseModel;
        $this->userModel = $userModel;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function withoutRedirect()
    {
        return [
            'stripe',
        ];
    }

    public function findPaymentMethod($paymentMethod)
    {

        if($paymentMethod == 'Paynet' && module('PaynetGateway')){
            return  new PaynetGatewayController();
        }else{
            $paymentMethod = 'Modules\Payment\PaymentMethods\\' . $paymentMethod . '\method';
            return new $paymentMethod;
        }

        // dd( $paymentMethod);

    }
    public function findAdminPaymentMethod($paymentMethod)
    {
        $paymentMethod = 'Modules\Payment\PaymentMethods\\' . $paymentMethod . '\admin_method';
        return new $paymentMethod;
    }

    public function findApiPaymentMethod($paymentMethod)
    {
        $paymentMethod = 'Modules\Payment\PaymentMethods\\' . $paymentMethod . '\api_method';
        return new $paymentMethod;
    }

    public function tableHeader()
    {

        return [
            ___('common.SL No'),
            ___('common.Name'),
            ___('common.Image'),
            ___('ui_element.status'),
            ___('ui_element.action'),
        ];
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

    public function store($data)
    {
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $paymentMethod = $this->model->find($id);
            if (!$paymentMethod) {
                return $this->responseWithError(___('alert.Payment method not found.'), [], 400);
            }
            $paymentMethod->title = $request->title;
            $paymentMethod->status_id = $request->status_id;
            // image_file upload
            if ($request->hasFile('image_file')) {
                $upload = $this->uploadFile($request->image_file, 'payment_method/image_file', [], $paymentMethod->image_file, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $paymentMethod->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $paymentMethod->save(); // save data in database table
            DB::commit();
            return $this->responseWithSuccess(___('alert.Payment method updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $paymentMethod = $this->model->find($id);
            if (!$paymentMethod) {
                return $this->responseWithError(___('alert.Payment method not found.'), [], 400);
            }
            $paymentMethod->delete();
            return $this->responseWithSuccess(___('alert.Payment method deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
