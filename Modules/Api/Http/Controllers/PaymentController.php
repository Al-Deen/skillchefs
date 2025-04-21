<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Api\Collections\PaymentCollection;
use Modules\Api\Interfaces\OrderInterface;
use Modules\Order\Entities\Order;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Payment\Interfaces\PaymentInterface;

class PaymentController extends Controller
{
    use ApiReturnFormatTrait;

    private $orderRepository;
    private $paymentRepository;
    private $enrollRepository;
    private $cart;

    public function __construct(
        OrderInterface $orderRepository,
        PaymentInterface $paymentRepository,
        EnrollInterface $enrollRepository,
        Cart $cartModel) {
        $this->orderRepository = $orderRepository;
        $this->paymentRepository = $paymentRepository;
        $this->enrollRepository = $enrollRepository;
        $this->cart = $cartModel;
    }

    public function checkout($course_id, $user_id)
    {
        Auth::login(User::find($user_id));
        $model = $this->cart->where('user_id', $user_id)->delete();

        try {
            $data['carts'] = Session()->get('cart');
            if (!$data['carts']) {
                return view('api::payment', compact('data'));
            }
            $data['total_price'] = 0;
            $data['discount'] = 0;
            foreach ($data['carts'] as $key => $cart) {
                $data['total_price'] += $cart['price'];
                $data['discount'] += $cart['discount_price'];
            }
            $data['payment_method'] = $this->paymentRepository->model()->active()->get();
            session()->put('total_price', $data['total_price']);
            session()->put('discount', $data['discount']);
            $data['title'] = ___('frontend.Checkout'); // title
            return view('api::payment', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

        return view('api::payment', compact('data'));
    }

    public function payment($user_id, $course_id, $payment_method_name)
    {
        try {
            $payment_method = $this->paymentRepository->model()->where('name', $payment_method_name)->first();
            if (!$payment_method) {
                return $this->responseWithError([___('alert.Please_select_payment_method')]);
            }
            Auth::login(User::find($user_id));
            $data['user_id'] = $user_id;
            $data['course_id'] = $course_id;
            $data['payment_method'] = $payment_method_name;
            $data['country'] = setting('country') ? setting('country') : 'Bangladesh';
            // order data

            $result = $this->orderRepository->store($data);

            session()->put('order_id', $result->original['data']->id);
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
                            return redirect()->route('webview_payment.done');
                        } else {
                            return redirect()->route('webview_payment.fail');
                        }
                    }
                    $payment = $this->paymentRepository->findApiPaymentMethod($payment_method_name);
                    $redirect = $payment->process($result->original['data']);
                    if (in_array($payment_method, $this->paymentRepository->withoutRedirect())) {
                        return $redirect;
                    }else{
                        if (!empty($redirect)) {
                            return redirect()->away($redirect);
                        }
                    }
                } catch (\Throwable $th) {
                    return redirect()->route('webview_payment.fail');
                }

            } else {
                return redirect()->route('webview_payment.fail');
            }
        } catch (\Throwable $th) {
            return redirect()->route('webview_payment.fail');
        }
    }

    public function paymentList()
    {
        try {
            $payments = $this->paymentRepository->model()->active()->get();
            $data['payments'] = new PaymentCollection($payments);
            return $this->responseWithSuccess(___('course.data found'), $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function done()
    {
        return "Transaction is Successful";
    }

    public function fail()
    {
        echo "Transaction is Failed";
    }

    public function cancel()
    {
        echo "Transaction is Cancel";
    }

    public function verify(Request $request, $gateway)
    {

        $payment_method = $this->paymentRepository->model()->where('name', $gateway)->first();

        dd($payment_method, $request, $gateway);

        try {

            if (@$request->get('status') == 'cancel') {
                return redirect()->route('webview_payment.fail')->with('danger', ___('alert.Cancelled_payment'));
            } elseif (@$request->get('status') == 'fail') {
                return redirect()->route('webview_payment.fail')->with('danger', ___('alert.Failed_payment'));
            }
            $payment = $this->paymentRepository->findPaymentMethod($payment_method->name);

            $order = $payment->verify($request);

            if (@$order) {
                if ($order->status == 'processing') {
                    $result = $this->enrollRepository->store($order);
                    if ($result->original['result']) {
                        $order->update([
                            'status' => 'paid',
                            'paid_amount' => $order->total_amount,
                            'due_amount' => 0,
                        ]);
                    } else {
                        return redirect()->route('webview_payment.fail')->with('danger', ___('alert.Payment gateway error'));
                    }
                }
                session()->put('order_id', $order->id);
                return redirect()->route('api.payment.status');
            } else {
                return redirect()->route('webview_payment.fail')->with('danger', ___('alert.Payment gateway error'));
            }
        } catch (\Exception $exception) {
            return redirect()->route('webview_payment.fail')->with('danger', ___('alert.Payment gateway error'));
        }
    }

    public function status(Request $request)
    {
        try {
            $orderId = $request->get('order_id', null);
            if (!empty(session()->get('order_id', null))) {
                $orderId = session()->get('order_id', null);
                session()->forget('order_id');
                session()->forget('cart');
                session()->forget('total_price');
                session()->forget('discount');
            }
            $order = Order::where('id', $orderId)
                ->where('user_id', auth()->id())
                ->first();

            if (!empty($order)) {
                return redirect()->route('webview_payment.done')->with('success', ___('alert.Payment successfully completed'));
            }
            return redirect()->route('webview_payment.done')->with('success', ___('alert.Payment successfully completed'));
        } catch (\Throwable $th) {
            return redirect()->route('webview_payment.fail')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
