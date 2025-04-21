<?php

namespace App\Http\Controllers\Api\V1\Student;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    use ApiReturnFormatTrait;

    public function index()
    {

        try {
            $options = [];

            $data = [
                'title'     => ___('frontend.About Us'),
                'content' => view('frontend.about', ['options' => $options])->render()
            ];

            return $this->responseWithSuccess(___('alert.Data found.'),$data); // return success response from ApiReturnFormatTrait

        } catch (\Throwable $th) {

            return $this->responseWithError( ___('alert.something_went_wrong_please_try_again'));
        }

    }

}
