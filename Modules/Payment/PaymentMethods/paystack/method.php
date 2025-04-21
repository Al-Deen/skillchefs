<?php

namespace Modules\Payment\PaymentMethods\paystack;

use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Unicodeveloper\Paystack\Paystack;

class method
{
    protected $currency;
    /**
     * Channel constructor.
     */
    public function __construct()
    {
        $this->currency = getCurrency();
    }

    public function process(Order $order)
    {
        $payStack = new Paystack();

        $payStack->getAuthorizationResponse([
            "amount" => $order->total_amount * 1000,
            "reference" => $payStack->genTranxRef(),
            "email" => $order->user->email,
            "callback_url" => $this->callBackUrl(),
            'metadata' => json_encode(['transaction' => $order->id]),
            'currency' => $this->currency
        ]);

        return $payStack->url;
    }

    private function callBackUrl()
    {
        return url("payments/verify/paystack"); 
    }

    public function verify(Request $request)
    {
        $user = auth()->user();
        $payment = Paystack::getPaymentData();

        $order = Order::find($payment['data']['metadata']['transaction']);
        $order->update(['status' => 'failed']);

        if (isset($payment['status']) && $payment['status'] == true) {
            $order->update([
                'status' => 'processing',
                'payment_details' => json_encode($payment)
            ]);
        }

        return $order;
    }
}
