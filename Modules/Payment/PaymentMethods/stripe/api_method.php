<?php

namespace Modules\Payment\PaymentMethods\stripe;


use Stripe\Stripe;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Modules\Order\Entities\Order;

class api_method
{
    protected $currency;
    protected $api_key;
    protected $api_secret;
    protected $order_id;


    public function __construct()
    {
        $this->currency = getCurrency();
        $this->api_key = env('STRIPE_KEY');
        $this->api_secret = env('STRIPE_SECRET');
        $this->order_id = 'stripe.payments.order_id';
    }

    public function process(Order $order)
    {
        $price = $order->total_amount;

        Stripe::setApiKey($this->api_secret);
        $checkout = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $this->currency,
                    'unit_amount_decimal' => $price * 100,
                    'product_data' => [
                        'name' => setting('application_name') . ' payment',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->callBackUrl('success'),
            'cancel_url' => $this->callBackUrl('cancel'),
        ]);
        session()->put($this->order_id, $order->id);
        $Html = '<html><head><title>Redirecting...</title>';
        $Html .= '<script src="https://js.stripe.com/v3/"></script>';
        $Html .= '</head><body>';
        $Html .= '<script type="text/javascript">let stripe = Stripe("' . $this->api_key . '");';
        $Html .= 'stripe.redirectToCheckout({ sessionId: "' . $checkout->id . '" }); </script>';
        $Html .= '</body></html>';
        echo $Html;
    }

    private function callBackUrl($status)
    {
        return url("api/payments/verify/stripe?status=$status&session_id={CHECKOUT_SESSION_ID}");
    }

    public function verify(Request $request)
    {
        $data = $request->all();
        $status = $data['status'];

        $order_id = session()->get($this->order_id, null);
        session()->forget($this->order_id);

        $user = auth()->user();

        $order = Order::where('id', $order_id)
            ->where('user_id', $user->id)
            ->first();

        if ($status == 'success' and !empty($request->session_id) and !empty($order)) {
            Stripe::setApiKey($this->api_secret);
            $session = Session::retrieve($request->session_id);
            if (!empty($session) and $session->payment_status == 'paid') {
                $order->update([
                    'status' => 'processing',
                    'payment_details' => json_encode($session)
                ]);
                return $order;
            }
        }
        if (!empty($order)) {
            $order->update(['status' =>'failed']);
        }

        return $order;
    }
}
