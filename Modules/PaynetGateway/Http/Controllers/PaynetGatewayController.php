<?php

namespace Modules\PaynetGateway\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Support\Renderable;
use Modules\Order\Interfaces\OrderInterface;
use Modules\Event\Entities\EventRegistration;
use Modules\Subscription\Entities\PackagePurchase;

class PaynetGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */


    public $apiUrl;
    public $secretKey;

    public function __construct(){
        $this->apiUrl = env('PAYNET_API_URL');
        $this->secretKey = env('PAYNET_SECRET');
    }

    private function payment_curl_api($token_id, $session_id, $amount){

        $params = [
            'session_id' => $session_id,
            'token_id' => $token_id,
            'transaction_type' => 1,
            'amount' => $amount,
            'add_comission_amount' => false,
            'ratio_code' => '',
            'installments' => '',
            'no_instalment' => false,
            'tds_required' => true
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json; charset=UTF-8',
            'Content-Type' => 'application/json; charset=UTF-8',
            'Authorization' => 'Basic ' . $this->secretKey,
        ])->post($this->apiUrl, $params);

        return $response->json();
    }

    public function process($order, $input)
    {
        $token_id = $input['token_id'];
        $session_id = $input['session_id'];

        if(!env('PAYNET_SECRET') && !env('PAYNET_PUBLIC') && !env('PAYNET_API_URL')){
            return $this->callBackUrl('fail', $order->id);
        }

        $result = $this->payment_curl_api($token_id, $session_id, $order['total_amount']);

        session()->put('order_id',$order->id);

        if(isset($result) && $result['code'] == 0){
            $order->update([
                'status' => 'processing',
                'payment_details' => json_encode($result)
            ]);

            Log::info('One');
            return $this->callBackUrl('success', $order->id);
        }else{
            $order->update([
                'status' => 'failed',
                'payment_details' => json_encode($result)
            ]);
            Log::info('Two');
        }

        Log::info('Three');
        return $this->callBackUrl('fail', $order->id);
    }

    public function event_process($event, $input)
    {

        $token_id = $input['token_id'];
        $session_id = $input['session_id'];

        if(!env('PAYNET_SECRET') && !env('PAYNET_PUBLIC') && !env('PAYNET_API_URL')){
            return $this->event_callBackUrl('fail', $event->id);
        }

        $result = $this->payment_curl_api($token_id, $session_id, intval($event->price));

        session()->put('event_id', $event->id);
        if(isset($result) && $result['code'] == 0){
            $event->update([
                'status' => 'processing',
                'payment_details' => json_encode($result)
            ]);
            return $this->event_callBackUrl('success');
        }else{
            $event->update([
                'status' => 'failed',
                'payment_details' => json_encode($result)
            ]);
        }
        return $this->event_callBackUrl('fail');
    }

    public function package_process($package, $input)
    {

        $token_id = $input['token_id'];
        $session_id = $input['session_id'];

        if(!env('PAYNET_SECRET') && !env('PAYNET_PUBLIC') && !env('PAYNET_API_URL')){
            return $this->event_callBackUrl('fail', $package->id);
        }

        $result = $this->payment_curl_api($token_id, $session_id, intval($package->price));

        session()->put('package_id', $package->id);

        if(isset($result) && $result['code'] == 0){
            $package->update([
                'status' => 'processing',
                'payment_details' => json_encode($result)
            ]);
            return $this->package_callBackUrl('success');
        }else{
            $package->update([
                'status' => 'failed',
                'payment_details' => json_encode($result)
            ]);
        }
        return $this->package_callBackUrl('fail');
    }

    private function callBackUrl($status, $order_id)
    {
        return url("payments/verify/Paynet?status=$status&session_id=$order_id");
    }

    private function event_callBackUrl($status)
    {
        return url("event_payments/verify/Paynet?status=$status&session_id={CHECKOUT_SESSION_ID}");
    }

    private function package_callBackUrl($status)
    {
        return url("package_payments/verify/Paynet?status=$status&session_id={CHECKOUT_SESSION_ID}");
    }

    public function verify(Request $request)
    {
        $data = $request->all();
        $status = $data['status'];
        $order_id = session()->get('order_id');
        session()->forget('order_id');

        $user = auth()->user();
        $order = Order::where('id', $order_id)
            ->where('user_id', $user->id)
            ->first();


        if ($status == 'success' and !empty($request->session_id) and !empty($order)) {
            $order->update([
                'status' => 'processing',
            ]);
        }else{
            $order->update(['status' =>'failed']);
        }

        return $order;
    }

    public function event_verify(Request $request){
        $data = $request->all();
        $status = $data['status'];
        $event_id = session()->get('event_id');
        session()->forget('event_id');
        $user = auth()->user();
        $event = EventRegistration::where('id', $event_id)->where('user_id', $user->id)->first();
        if ($status == 'success' and !empty($request->session_id) and !empty($event)) {
            $event->update([
                'status' => 'processing',
            ]);
        } else{
            $event->update(['status' =>'failed']);
        }
        return $event;
    }

    public function package_verify(Request $request){
        $data = $request->all();
        $status = $data['status'];
        $package_id = session()->get('package_id');
        session()->forget('package_id');
        $user = auth()->user();
        $package = PackagePurchase::where('id', $package_id)->where('user_id', $user->id)->first();
        if ($status == 'success' and !empty($request->session_id) and !empty($package)) {
            $package->update([
                'status' => 'processing',
            ]);
            return $package;
        } else{
            $package->update(['status' =>'failed']);
        }
        return $package;
    }
}
