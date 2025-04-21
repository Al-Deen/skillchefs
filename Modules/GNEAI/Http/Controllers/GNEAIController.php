<?php

namespace Modules\GNEAI\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class GNEAIController extends Controller
{
    use ApiReturnFormatTrait;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $data['title'] = ___('common.AI_Support'); // title
            return view('gneai::index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function search(Request $request)
    {
        try {
            $open_secret = setting('OPEN_AI_KEY') ?? '';
            $dataString = json_encode([
                "model" => "gpt-3.5-turbo",
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $request->text,
                    ],
                ],
                "temperature" => 0.7,
            ]);
            $header = [
                "Authorization: Bearer " . $open_secret,
                "Content-Type: application/json",
            ];
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);
            return $this->responseWithSuccess(___('alert.Data retrieve successfully.'), $response);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
