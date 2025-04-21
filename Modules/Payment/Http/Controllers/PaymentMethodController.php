<?php

namespace Modules\Payment\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payment\Http\Requests\PaymentMethodRequest;
use Modules\Payment\Interfaces\PaymentInterface;

class PaymentMethodController extends Controller
{
    use ApiReturnFormatTrait;

    protected $payment;

    // constructor injection
    public function __construct(
        PaymentInterface $paymentInterface
    ) {
        $this->payment = $paymentInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {

        try {
            $data['tableHeader'] = $this->payment->tableHeader(); // table header
            $data['payments'] = $this->payment->model()->search($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('payment_method.Payment Method'); // title
            return view('payment::payment_method.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {

            $data['title'] = ___('payment_method.Edit_Payment_Method'); // title
            $data['button'] = ___('common.Update');
            $data['payment'] = $this->payment->model()->find($id);
            $data['url'] = route('payment_method.update', $id);
            $html = view('payment::payment_method.modal.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PaymentMethodRequest $request, $id)
    {
        try {
            $result = $this->payment->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $result = $this->payment->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->back()->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
