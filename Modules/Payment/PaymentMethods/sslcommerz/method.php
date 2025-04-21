<?php

namespace Modules\Payment\PaymentMethods\sslcommerz;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Event\Entities\EventRegistration;
use Modules\Order\Entities\Order;
use Modules\Payment\PaymentMethods\sslcommerz\SSLCommerz;
use Modules\Subscription\Entities\PackagePurchase;

class method
{
    protected $currency;
    protected $order_id;
    protected $package_id;
    protected $event_id;

    public function __construct()
    {
        $this->currency = "BDT"; //currency();
        $this->order_id = 'sslcommerz.payments.order_id';
        $this->package_id = 'stripe.payments.package_id';
        $this->event_id = 'stripe.payments.event_id';
    }

    public function process(Order $order)
    {
        $user = $order->user;

        $postData = [];

        $postData['total_amount'] = $order->total_amount; # You cant not pay less than 10
        $postData['currency'] = "BDT";
        $postData['tran_id'] = substr(md5($order->id), 0, 10); // tran_id must be unique

        $postData['value_a'] = $postData['tran_id'];
        $postData['value_b'] = $order->id;
        $postData['value_c'] = $order->user_id;

        # CUSTOMER INFORMATION
        $postData['cus_name'] = $user->name;
        $postData['cus_add1'] = @$user->address ?? "dhaka, Bangladesh";
        $postData['cus_city'] = @$user->city ?? "dhaka";
        $postData['cus_postcode'] = 123;
        $postData['cus_country'] = @$user->country ?? "Bangladesh";
        $postData['cus_phone'] = @$user->phone;
        $postData['cus_email'] = @$user->email;

        $postData['success_url'] = url("/payments/verify/sslcommerz?status=success");
        $postData['fail_url'] = url("/payments/verify/sslcommerz?status=fail");
        $postData['cancel_url'] = url("/payments/verify/sslcommerz?status=cancel");

        session()->put($this->order_id, $order->id);

        $sslc = new SSLCommerz();
        $payment_options = $sslc->initiate($postData, false);
        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function package_process(PackagePurchase $package)
    {
        $user = $package->user;
        $postData = [];

        $postData['total_amount'] = $package->amount; # You cant not pay less than 10
        $postData['currency'] = "BDT";
        $postData['tran_id'] = substr(md5($package->id), 0, 10); // tran_id must be unique

        $postData['value_a'] = $postData['tran_id'];
        $postData['value_b'] = $package->id;
        $postData['value_c'] = $package->user_id;

        # CUSTOMER INFORMATION
        $postData['cus_name'] = $user->name;
        $postData['cus_add1'] = @$user->address ?? "dhaka, Bangladesh";
        $postData['cus_city'] = @$user->city ?? "dhaka";
        $postData['cus_postcode'] = 123;
        $postData['cus_country'] = @$user->country ?? "Bangladesh";
        $postData['cus_phone'] = @$user->phone;
        $postData['cus_email'] = @$user->email;

        $postData['success_url'] = url("/package_payments/verify/sslcommerz?status=success");
        $postData['fail_url'] = url("/package_payments/verify/sslcommerz?status=fail");
        $postData['cancel_url'] = url("/package_payments/verify/sslcommerz?status=cancel");

        session()->put($this->package_id, $package->id);

        $sslc = new SSLCommerz();
        $payment_options = $sslc->initiate($postData, false);
        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function event_process(EventRegistration $event)
    {
        $user = $event->user;
        $postData = [];

        $postData['total_amount'] = $event->price; # You cant not pay less than 10
        $postData['currency'] = "BDT";
        $postData['tran_id'] = substr(md5($event->id), 0, 10); // tran_id must be unique

        $postData['value_a'] = $postData['tran_id'];
        $postData['value_b'] = $event->id;
        $postData['value_c'] = $event->user_id;

        # CUSTOMER INFORMATION
        $postData['cus_name'] = $user->name;
        $postData['cus_add1'] = @$user->address ?? "dhaka, Bangladesh";
        $postData['cus_city'] = @$user->city ?? "dhaka";
        $postData['cus_postcode'] = 123;
        $postData['cus_country'] = @$user->country ?? "Bangladesh";
        $postData['cus_phone'] = @$user->phone;
        $postData['cus_email'] = @$user->email;

        $postData['success_url'] = url("/event_payments/verify/sslcommerz?status=success");
        $postData['fail_url'] = url("/event_payments/verify/sslcommerz?status=fail");
        $postData['cancel_url'] = url("/event_payments/verify/sslcommerz?status=cancel");

        session()->put($this->event_id, $event->id);

        $sslc = new SSLCommerz();
        $payment_options = $sslc->initiate($postData, false);
        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function verify(Request $request)
    {
        $status = $request->get('status');
        session()->forget($this->order_id);
        $user = Auth::login(User::find($request->value_c));
        $order = Order::where('id', $request->value_b)
            ->where('user_id', $request->value_c)
            ->with('user')
            ->first();

        if (!empty($order)) {

            $order->update([
                'status' => 'failed',
            ]);

            if ($status == 'success') {
                $order->update([
                    'status' => 'processing',
                    'payment_details' => json_encode($request->all()),
                ]);
            }
        }

        return $order;
    }
    public function package_verify(Request $request)
    {
        $status = $request->get('status');
        session()->forget($this->order_id);
        $user = Auth::login(User::find($request->value_c));
        $order = PackagePurchase::where('id', $request->value_b)
            ->where('user_id', $request->value_c)
            ->with('user')
            ->first();
        if (!empty($order)) {

            $order->update([
                'status' => 'failed',
            ]);

            if ($status == 'success') {
                $order->update([
                    'status' => 'processing',
                    'payment_details' => json_encode($request->all()),
                ]);
            }
        }

        return $order;
    }
    public function event_verify(Request $request)
    {
        $status = $request->get('status');
        session()->forget($this->event_id);
        $user = Auth::login(User::find($request->value_c));
        $event = EventRegistration::where('id', $request->value_b)->where('user_id', $request->value_c)->first();
        if (!empty($event)) {
            $event->update([
                'status' => 'failed',
            ]);

            if ($status == 'success') {
                $event->update([
                    'status' => 'processing',
                    'payment_details' => json_encode($request->all()),
                ]);
            }
        }

        return $event;
    }
}
