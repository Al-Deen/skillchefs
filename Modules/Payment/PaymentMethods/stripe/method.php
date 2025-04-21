<?php

namespace Modules\Payment\PaymentMethods\stripe;


use Stripe\Stripe;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Modules\Order\Entities\Order;
use Modules\Subscription\Entities\PackagePurchase;
use Modules\Event\Entities\EventRegistration;

class method
{
    protected $currency;
    protected $api_key;
    protected $api_secret;
    protected $order_id;
    protected $package_id;
    protected $event_id;


    public function __construct()
    {
        $this->currency = getCurrency();
        $this->api_key = env('STRIPE_KEY');
        $this->api_secret = env('STRIPE_SECRET');
        $this->order_id = 'stripe.payments.order_id';
        $this->package_id = 'stripe.payments.package_id';
        $this->event_id = 'stripe.payments.event_id';
    }

    public function process(Order $order)
    {
        $price = $order->total_amount;

        Stripe::setApiKey($this->api_secret);
        $stripe = new \Stripe\StripeClient($this->api_secret);
        $customer = $stripe->customers->create([
            'description' => 'lms course description',
            'email' => $order->user->email,
            'payment_method' => 'pm_card_visa',
        ]);
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
        return url("payments/verify/stripe?status=$status&session_id={CHECKOUT_SESSION_ID}");
    }

    // subscription package stripe process
    public function package_process(PackagePurchase $package)
    {
        $price = $package->amount;
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
            'success_url' => $this->package_callBackUrl('success'),
            'cancel_url' => $this->package_callBackUrl('cancel'),
        ]);
        session()->put($this->package_id, $package->id);
        $Html = '<html><head><title>Redirecting...</title>';
        $Html .= '<script src="https://js.stripe.com/v3/"></script>';
        $Html .= '</head><body>';
        $Html .= '<script type="text/javascript">let stripe = Stripe("' . $this->api_key . '");';
        $Html .= 'stripe.redirectToCheckout({ sessionId: "' . $checkout->id . '" }); </script>';
        $Html .= '</body></html>';
        echo $Html;
    }

    private function package_callBackUrl($status)
    {
        return url("package_payments/verify/stripe?status=$status&session_id={CHECKOUT_SESSION_ID}");
    }

    // event stripe process
    public function event_process(EventRegistration $event)
    {
        Stripe::setApiKey($this->api_secret);
        $checkout = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $this->currency,
                    'unit_amount_decimal' => $event->price * 100,
                    'product_data' => [
                        'name' => setting('application_name') . ' payment',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->event_callBackUrl('success'),
            'cancel_url' => $this->event_callBackUrl('cancel'),
        ]);
        session()->put($this->event_id, $event->id);
        $Html = '<html><head><title>Redirecting...</title>';
        $Html .= '<script src="https://js.stripe.com/v3/"></script>';
        $Html .= '</head><body>';
        $Html .= '<script type="text/javascript">let stripe = Stripe("' . $this->api_key . '");';
        $Html .= 'stripe.redirectToCheckout({ sessionId: "' . $checkout->id . '" }); </script>';
        $Html .= '</body></html>';
        echo $Html;
    }

    private function event_callBackUrl($status)
    {
        return url("event_payments/verify/stripe?status=$status&session_id={CHECKOUT_SESSION_ID}");
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

    public function package_verify(Request $request){
        $data = $request->all();
        $status = $data['status'];

        $package_id = session()->get($this->package_id, null);
        session()->forget($this->package_id);
        $user = auth()->user();
        $package = PackagePurchase::where('id', $package_id)->where('user_id', $user->id)->first();

        if ($status == 'success' and !empty($request->session_id) and !empty($package)) {
            Stripe::setApiKey($this->api_secret);
            $session = Session::retrieve($request->session_id);
            if (!empty($session) and $session->payment_status == 'paid') {
                $package->update([
                    'status' => 'processing',
                    'payment_details' => json_encode($session)
                ]);
                return $package;
            }
        }
        if (!empty($package)) {
            $package->update(['status' =>'failed']);
        }
        return $package;
    }

    public function event_verify(Request $request){
        $data = $request->all();
        $status = $data['status'];

        $event_id = session()->get($this->event_id, null);
        session()->forget($this->event_id);
        $user = auth()->user();
        $event = EventRegistration::where('id', $event_id)->where('user_id', $user->id)->first();

        if ($status == 'success' and !empty($request->session_id) and !empty($event)) {
            Stripe::setApiKey($this->api_secret);
            $session = Session::retrieve($request->session_id);
            if (!empty($session) and $session->payment_status == 'paid') {
                $event->update([
                    'status' => 'processing',
                    'payment_details' => json_encode($session)
                ]);
                return $event;
            }
        }
        if (!empty($event)) {
            $event->update(['status' =>'failed']);
        }
        return $event;
    }
}
