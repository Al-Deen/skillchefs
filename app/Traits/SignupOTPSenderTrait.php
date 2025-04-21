<?php

namespace App\Traits;

use Twilio\Rest\Client;

trait SignupOTPSenderTrait
{

    public function SendSignupOTP($text, $mobile)
    {
        try{
           $sid = env('TWILIO_SID');
           $token = env('TWILIO_TOKEN');
           $number_from = env('TWILIO_FROM');
           $twilio = new Client($sid, $token);
           $message = $twilio->messages->create($mobile, // to
                [
                    "body" => $text,
                    "from" => $number_from,
                    //"statusCallback" => "http://postb.in/1234abcd"
                ]
            );
            return [
               'result' => true,
               'message' => ___('two_fa.OTP_send_successfully')
            ];
       } catch (\Exception $e){
           return [
               'result' => false,
               'message' => $e->getMessage()
           ];
        }
    }
}
