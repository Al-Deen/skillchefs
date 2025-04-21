<?php

namespace Modules\Payment\PaymentMethods\sslcommerz;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Instructor\Entities\Payout;
use Modules\Payment\PaymentMethods\sslcommerz\SSLCommerz;

class admin_method
{
    protected $currency;
    protected $payout_id;

    public function __construct()
    {
        $this->currency = "BDT"; //currency();
        $this->payout_id = 'sslcommerz.payments.payout_id';

    }

    public function process(Payout $payout)
    {
        $user = $payout->user;

        $postData = [];

        $postData['total_amount'] = $payout->amount; # You cant not pay less than 10
        $postData['currency'] = "BDT";
        $postData['tran_id'] = substr(md5($payout->id), 0, 10); // tran_id must be unique

        $postData['value_a'] = $postData['tran_id'];
        $postData['value_b'] = $payout->id;
        $postData['value_c'] = auth()->user()->id;

        # CUSTOMER INFORMATION
        $postData['cus_name'] = $user->name;
        $postData['cus_add1'] = @$user->address ?? "dhaka, Bangladesh";
        $postData['cus_city'] = @$user->city ?? "dhaka";
        $postData['cus_postcode'] = 123;
        $postData['cus_country'] = @$user->country ?? "Bangladesh";
        $postData['cus_phone'] = @$user->mobile;
        $postData['cus_email'] = @$user->email;

        $postData['success_url'] = $this->callBackUrl('success');
        $postData['fail_url'] = $this->callBackUrl('fail');
        $postData['cancel_url'] = $this->callBackUrl('cancel');

        session()->put($this->payout_id, $payout->id);

        $sslc = new SSLCommerz();
        $payment_options = $sslc->initiate($postData, false);
        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    private function callBackUrl($status)
    {
        return route('admin.payment.verify', 'sslcommerz') . "?status=$status";
    }

    public function verify(Request $request)
    {
        $payout_id = $request->value_b;
        $status = $request->get('status');
        $payout = Payout::where('id', $payout_id)->first();
        Auth::login(User::find($request->value_c));
        if (!empty($payout)) {
            if ($status == 'success') {
                $payout->payment_status_id = 8;
                $payout->payment_details = json_encode($request->all());
                $payout->save();
                return $payout;
            }
        }

        return false;
    }
}
