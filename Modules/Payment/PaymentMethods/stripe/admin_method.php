<?php

namespace Modules\Payment\PaymentMethods\stripe;

use Illuminate\Http\Request;
use Modules\Instructor\Entities\Payout;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class admin_method
{
    protected $currency;
    protected $payout_id;

    public function __construct()
    {
        $this->currency = getCurrency();
        $this->payout_id = 'stripe.payments.payout_id';
    }

    public function process(Payout $payout)
    {
        $price = $payout->amount;
        $api_secret = $payout->instructorPaymentMethod->credentials['STRIPE_SECRET'];
        $api_key = $payout->instructorPaymentMethod->credentials['STRIPE_KEY'];

        Stripe::setApiKey($api_secret);
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
        session()->put($this->payout_id, $payout->id);
        $Html = '<html><head><title>Redirecting...</title>';
        $Html .= '<script src="https://js.stripe.com/v3/"></script>';
        $Html .= '</head><body>';
        $Html .= '<script type="text/javascript">let stripe = Stripe("' . $api_key . '");';
        $Html .= 'stripe.redirectToCheckout({ sessionId: "' . $checkout->id . '" }); </script>';
        $Html .= '</body></html>';
        echo $Html;
    }

    private function callBackUrl($status)
    {
        return route('admin.payment.verify', 'stripe') . "?status=$status&session_id={CHECKOUT_SESSION_ID}";
    }

    public function verify(Request $request)
    {
        $data = $request->all();
        $status = $data['status'];

        $payout_id = session()->get($this->payout_id, null);
        session()->forget($this->payout_id);

        $payout = Payout::where('id', $payout_id)
            ->first();

        $api_secret = $payout->instructorPaymentMethod->credentials['STRIPE_SECRET'];

        if ($status == 'success' and !empty($request->session_id) and !empty($payout)) {
            Stripe::setApiKey($api_secret);
            $session = Session::retrieve($request->session_id);
            if (!empty($session) and $session->payment_status == 'paid') {
                $payout->update([
                    'payment_status_id' => 8,
                    'payment_details' => json_encode($session),
                ]);
                return $payout;
            }
        }
        return $payout;
    }
}
