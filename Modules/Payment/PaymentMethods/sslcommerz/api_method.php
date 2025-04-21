<?php

namespace Modules\Payment\PaymentMethods\sslcommerz;

use App\Models\User;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\Auth;
use Modules\Payment\PaymentMethods\sslcommerz\SSLCommerz;

class api_method
{
    protected $currency;
    protected $order_id;

    public function __construct()
    {
        $this->currency = "BDT";//currency();
        $this->order_id = 'sslcommerz.payments.order_id';

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
        $postData['cus_phone'] = @$user->mobile;
        $postData['cus_email'] = @$user->email;

        $postData['success_url'] = url("/api/payments/verify/sslcommerz?status=success");
        $postData['fail_url'] = url("/api/payments/verify/sslcommerz?status=fail");
        $postData['cancel_url'] = url("/api/payments/verify/sslcommerz?status=cancel");

        session()->put($this->order_id, $order->id);

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
                'status' => 'failed'
            ]);

            if ($status == 'success') {
                $order->update([
                    'status' => 'processing',
                    'payment_details' => json_encode($request->all())
                ]);
            }
        }

        return $order;
    }
}
