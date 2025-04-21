<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{


    public function register()
    {
        return view('frontend.register');
    }

    public function login()
    {
        return view('frontend.login');
    }

    public function forgotPassword()
    {
        return view('frontend.forgotPassword');
    }


    public function becomeStudent()
    {
        return view('frontend.student.become_student');
    }



    public function privacyPolicy()
    {
        return view('frontend.privacy_policy');
    }

}
