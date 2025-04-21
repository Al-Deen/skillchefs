<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Instructor\Http\Requests\InstructorPaymentMethodRequest;
use Modules\Instructor\Interfaces\InstructorInterface;
use Modules\Instructor\Interfaces\InstructorPaymentMethodInterface;
use Modules\Payment\Interfaces\PaymentInterface;

class PaymentMethodController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $instructor;
    protected $paymentMethodRepository;
    protected $instructorPaymentMethodRepository;

    public function __construct(
        InstructorInterface $instructor,
        PaymentInterface $paymentMethodRepository,
        InstructorPaymentMethodInterface $instructorPaymentMethodRepository
    ) {
        $this->instructor = $instructor;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->instructorPaymentMethodRepository = $instructorPaymentMethodRepository;
    }
    public function payoutSettings()
    {
        try {
            $data['title'] = ___('instructor.Payment Account List'); // title
            $data['payment_methods'] = $this->instructorPaymentMethodRepository->filter(['user_id' => auth()->user()->id])->get(); // payment methods
            return view('panel.instructor.financial.payout_settings', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function create()
    {

        try {
            $data['url'] = route('instructor.payment_method.store'); // url
            $data['title'] = ___('instructor.Add Payment Account'); // title
            $data['payment_methods'] = $this->paymentMethodRepository->model()->where('status_id', 1)->get(); // payment methods
            @$data['button'] = ___('common.Save');
            $html = view('panel.instructor.modal.payment.create_payment_account', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function store(InstructorPaymentMethodRequest $request)
    {
        try {
            $result = $this->instructorPaymentMethodRepository->store($request); // create
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function edit($id)
    {

        try {
            $data['payment_method'] = $this->instructorPaymentMethodRepository->filter(['id' => $id, 'user_id' => auth()->user()->id])->first(); // payment method
            if (!$data['payment_method']) {
                return $this->responseWithError(___('alert.Payment Not Found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.payment_method.update', $id); // url
            $data['title'] = ___('instructor.Edit Payment Account'); // title
            $data['payment_methods'] = $this->paymentMethodRepository->model()->where('status_id', 1)->get(); // payment methods
            @$data['button'] = ___('common.Save');
            $html = view('panel.instructor.modal.payment.edit_payment_account', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function update(InstructorPaymentMethodRequest $request, $id)
    {
        try {
            $result = $this->instructorPaymentMethodRepository->update($request, $id); // update
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

}
