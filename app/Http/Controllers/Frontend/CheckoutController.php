<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Redirect;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Order\Interfaces\OrderInterface;
use Modules\Payment\Interfaces\PaymentInterface;

class CheckoutController extends Controller
{
    use ApiReturnFormatTrait;

    private $orderRepository;
    private $paymentRepository;
    private $enrollRepository;

    public function __construct(OrderInterface $orderRepository, PaymentInterface $paymentRepository, EnrollInterface $enrollRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->paymentRepository = $paymentRepository;
        $this->enrollRepository = $enrollRepository;
    }

    public function index()
    {
        try {
            $data['carts'] = Session()->get('cart');
            if (!$data['carts']) {
                return redirect()->route('home')->with('danger', ___('alert.Cart_is_empty'));
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
            return view('frontend.checkout', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    // payment

    public function payment(CheckoutRequest $request)
    {

        try {
            if ($request->payment_method != 'offline') {
                $payment_method = $request->payment_method;
            } else {
                $payment_method = 'offline';
                $data['payment_type'] = $request->payment_type;
                $data['additional_details'] = $request->additional_details;
            }
            if (!$payment_method) {
                return redirect()->back()->with('danger', ___('alert.Please_select_payment_method'));
            }
            $data['carts'] = Session()->get('cart');

            if (!$data['carts']) {
                return redirect()->route('home')->with('danger', ___('alert.Cart_is_empty'));
            }
            $data['payment_method'] = $payment_method;
            $data['country'] = setting('country') ? setting('country') : 'Bangladesh';



            // order data
            $result = $this->orderRepository->store($data);

            // dd($result->original['data'], $request->all());


            session()->put('order_id', $result->original['data']->id);
            if ($result->original['result']) {
                try {
                    if ($result->original['data']->total_amount == 0 || $payment_method === 'offline') {
                        if ($payment_method != 'offline') {
                            $resultRepo = $this->enrollRepository->store($result->original['data']);
                            if ($resultRepo->original['result']) {
                                // subscription course enroll update
                                if (module('Subscription') && setting('subscription_setup')) {
                                    foreach ($data['carts'] as $key => $cart) {
                                        $packageCourseRepository = new \Modules\Subscription\Repositories\PackageCourseRepository(new \Modules\Subscription\Entities\PackageCourse);
                                        $package_course = $packageCourseRepository->model()->where(['course_id' => $cart['course_id'], 'status_id' => 4])->first();
                                        if ($package_course) {
                                            $packagePurchaseRepository = new \Modules\Subscription\Repositories\PackagePurchaseRepository(new \Modules\Subscription\Entities\PackagePurchase, new \Modules\Subscription\Entities\PackageLog);
                                            $packagePurchaseRepository->updateCourseEnroll($package_course->package_id);
                                        }
                                    }
                                }
                                // subscription course enroll update end

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
                    }
                    if ($payment_method === 'offline') {
                        return redirect()->route('home')->with('success', ___('alert.Enroll successfully completed.Wait for admin approval'));
                    }
                    $payment = $this->paymentRepository->findPaymentMethod($payment_method);

                    if($payment_method == 'Paynet'){
                        $redirect = $payment->process($result->original['data'], $request->all());
                    }else{
                        $redirect = $payment->process($result->original['data']);
                    }


                    if (in_array($payment_method, $this->paymentRepository->withoutRedirect())) {
                        return $redirect;
                    }
                    return Redirect::away($redirect);
                } catch (\Throwable $th) {
                    return redirect()->route('checkout.index')->with('danger', ___('alert.Payment gateway error'));
                }
            } else {
                return redirect()->back()->with('danger', $result['message']);
            }
        } catch (\Throwable $th) {
            dd($th );
            return redirect()->route('checkout.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
