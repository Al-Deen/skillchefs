<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Log;

trait FCMNotification
{

    function sendFirebaseNotification($user_id, $notification_type, $id = null, $url, $title, $body, $image = null)
    {
        try {
            if (env('APP_ENV') == 'production' && !env('APP_SYNC')) {
                $firebaseToken = User::where('user_id', $user_id)->whereNotNull('device_token')->pluck('device_token')->all();
                $firebase_key = setting('firebase_key');
                $SERVER_API_KEY = @$firebase_key->value;
                $data = [
                    "registration_ids" => $firebaseToken,
                    "data" => [
                        "title" => $title,
                        "body" => $body,
                        "url" => $url,
                        "id" => $id,
                        "type" => $notification_type,
                        "image" => $image,
                    ],
                    "aps" => [
                        "title" => $title,
                        "body" => $body,
                        "badge" => "1",
                        "click_action" => $url,
                        "id" => $id,
                        "type" => $notification_type,
                        "sound" => "default",
                        "image" => $image,
                        "content_available" => true,
                        "priority" => "high",
                    ],
                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                $response = curl_exec($ch);
                return $response;
            } else {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
}
