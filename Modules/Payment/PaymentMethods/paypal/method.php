<?php

namespace Modules\Payment\PaymentMethods\paypal;

use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use Modules\Order\Entities\Order;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Redirect;
use PayPal\Exception\PayPalConnectionException;

class method
{
    private $_api_context;
    protected $currency;
    /**
     * Channel constructor.
     */
    public function __construct()
    {
        $this->currency = getCurrency();

        $paypal_conf = \Config::get('paypal');

        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function process(Order $order)
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $items = [];
        $item = new Item();
            $item->setName('charge')
                ->setCurrency($this->currency)
                ->setQuantity(1)
                ->setPrice($order->total_amount);

        $itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details();
        $details->setShipping(0)
            ->setTax($order->tax)
            ->setSubtotal($order->total_amount - $order->tax);

        $amount = new Amount();
        $amount->setCurrency($this->currency)
            ->setTotal($order->total_amount)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($this->callBackUrl())
            ->setCancelUrl($this->callBackUrl());

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (PayPalConnectionException $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        $paymentId = $payment->getId();
        $order->reference_id = $paymentId;
        $order->save();

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return $redirect_url;
        }
        return redirect()->route('checkout.index')->with('danger', ___('alert.Payment gateway error'));
    }

    private function callBackUrl()
    {
        return url("payments/verify/paypal"); 
    }

    public function verify(Request $request)
    {
        $user = auth()->user();

        $payment_id = $request->paymentId;
        if (!$payment_id) {
            return;
        }

        $order = Order::where('reference_id', $payment_id)->where('user_id', $user->id)->first();

        if ($order->status === 'paid') {
            return $order;
        }

        $order->update(['status' => 'failed']);

        if (empty($request->PayerID) || empty($request->token)) {
            return $order;
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
        try {
            $result = $payment->execute($execution, $this->_api_context);

        } catch (PayPalConnectionException $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        if ($result->getState() == 'approved') {
            $order->update([
                'status' => 'processing',
                'payment_details' => json_encode($result)
            ]);
        }

        return $order;
    }
}
