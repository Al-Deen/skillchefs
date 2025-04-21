<?php

namespace App\Http\Controllers\Api\V1\Student;

use Illuminate\Http\Request;
use App\Interfaces\CartInterface;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Support\Facades\Redirect;
use Modules\Order\Interfaces\OrderInterface;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Payment\Interfaces\PaymentInterface;

class CheckoutController extends Controller
{
    use ApiReturnFormatTrait;

    private $orderRepository;
    private $paymentRepository;
    private $enrollRepository;
    private $cart;

    public function __construct(OrderInterface $orderRepository, PaymentInterface $paymentRepository, EnrollInterface $enrollRepository, CartInterface $cartInterface)
    {
        $this->orderRepository          = $orderRepository;
        $this->paymentRepository        = $paymentRepository;
        $this->enrollRepository         = $enrollRepository;
        $this->cart                     = $cartInterface;
    }

    public function checkout(Request $request)
    {

        try {
            $data['carts'] = $this->cart->model()
                ->with('course:id,title,short_description,price,discount_price')
                ->where('user_id', auth()->id())->get();

            if (!$data['carts']) {
                return $this->responseWithSuccess(___('alert.Cart_is_empty'));
            }

            return $this->payment($data['carts'],$request->payment_method);
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    // payment

    public function payment($carts,$payment_method)
    {

        try {
            $payment_method = $payment_method ??  null;



            if (!$payment_method) {
                return $this->responseWithError(___('alert.Please_select_payment_method'));
            }

            if (!$carts) {
                return $this->responseWithError(___('alert.Cart_is_empty'));
            }
            $data['carts']          = $carts;
            $data['payment_method'] = $payment_method;
            $data['country']        = setting('country') ? setting('country') : 'Bangladesh';
            // order data


            $result = $this->orderRepository->store($data);

            if ($result->original['result']) {
                try {
                    if ($result->original['data']->total_amount == 0) {
                        $resultRepo = $this->enrollRepository->store($result->original['data']);
                        if ($resultRepo->original['result']) {
                            $result->original['data']->update([
                                'status' => 'paid',
                                'paid_amount' => 0,
                                'due_amount' => 0,
                            ]);

                            return redirect()->route('payment.status');
                        } else {
                            return redirect()->route('checkout.index')->with('danger', ___('alert.Payment gateway error'));
                        }
                    }
                    $payment = $this->paymentRepository->findPaymentMethod($payment_method);
                    $redirect = $payment->process($result->original['data']);
                    if (in_array($payment_method, $this->paymentRepository->withoutRedirect())) {
                        return $redirect;
                    }
                    return Redirect::away($redirect);
                } catch (\Throwable $th) {
                    return $this->responseWithError(___('alert.Payment gateway error'));
                }
            } else {
                return $this->responseWithError($result['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('checkout.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function paymentg(Request $request)
{
    try {
        $carts = $request->input('carts');
        $payment_method = $request->input('payment_method');

        if (!$payment_method) {
            return response()->json(['error' => 'Please select payment method'], 400);
        }

        if (!$carts) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $data['carts']          = $carts;
        $data['payment_method'] = $payment_method;
        $data['country']        = setting('country') ? setting('country') : 'Bangladesh';

        $result = $this->orderRepository->store($data);

        if ($result->original['result']) {
            try {
                if ($result->original['data']->total_amount == 0) {
                    $resultRepo = $this->enrollRepository->store($result->original['data']);
                    if ($resultRepo->original['result']) {
                        $result->original['data']->update([
                            'status' => 'paid',
                            'paid_amount' => 0,
                            'due_amount' => 0,
                        ]);
                        return response()->json(['success' => true, 'message' => 'Payment success'], 200);
                    } else {
                        return response()->json(['error' => 'Payment gateway error'], 400);
                    }
                }
                $payment = $this->paymentRepository->findPaymentMethod($payment_method);
                $redirect = $payment->process($result->original['data']);
                if (in_array($payment_method, $this->paymentRepository->withoutRedirect())) {
                    return response()->json(['redirect' => $redirect], 200);
                }
                return response()->json(['redirect' => $redirect], 302);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Payment gateway error'], 400);
            }
        } else {
            return response()->json(['error' => $result['message']], 400);
        }
    } catch (\Throwable $th) {
        return response()->json(['error' => 'Something went wrong, please try again'], 500);
    }
}

}
