<?php

namespace App\Interfaces;

interface AuthenticationRepositoryInterface
{
    public function login($request);

    public function panelLogin($request);

    public function logout();

    public function register($request);

    public function sendEmailVerification();
    
    public function sendMobileVerification();

    public function verifyOTPForPhoneNumber($request);

    public function verifyEmail($email, $expire);

    public function forgotPassword($request);

    public function resetPasswordPage($email, $token);

    public function resetPassword($request);
}
