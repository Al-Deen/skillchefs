<?php

namespace App\Repositories;

use DB;
use App\Models\User;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use App\Mail\EmailVerification;
use App\Events\ForgotPasswordEvent;
use App\Events\UserEmailVerifyEvent;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\SignupOTPSenderTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\AuthenticationRepositoryInterface;

class AuthenticationRepository implements AuthenticationRepositoryInterface
{
    use ApiReturnFormatTrait, SignupOTPSenderTrait;

    public function login($request)
    {
        $authenticate = Auth::attempt([
            'email' => data_get($request, 'email'),
            'password' => data_get($request, 'password'),
        ], data_get($request, 'rememberMe') ? true : false);

        if ($authenticate) {
            return true;
        }
        return false;
    }

    public function panelLogin($request)
    {
        try {
            $user = User::where('email', data_get($request, 'email'))->first();

            if (!$user) {
                return $this->responseWithError(___('alert.invalid_email_or_password'), 200);
            }

            $authenticate = Auth::attempt([
                'email' => data_get($request, 'email'),
                'password' => data_get($request, 'password'),
            ], data_get($request, 'rememberMe') ? true : false);

            if ($authenticate) {
                return $this->responseWithSuccess(1, ___('alert.login_successfully', $authenticate), 200);
            }
            return $this->responseWithError(___('alert.invalid_email_or_password'), 200);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), 200);
        }
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
    }

    public function register($request)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->date_of_birth = date('yy-m-d', strtotime($request->date_of_birth));
            $user->gender = $request->gender;
            $user->password = Hash::make($request->password);
            $user->token = Str::random(30);
            $user->role_id = 4;
            $user->save();

            \Config::set('mail.mailers.smtp.password', \Crypt::decrypt(\Config::get('mail.mailers.smtp.password')));
            Mail::to($user->email)->send(new EmailVerification($user));

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function sendEmailVerification()
    {
        try {
            $user = Auth::user();
            event(new UserEmailVerifyEvent($user));
            return $this->responseWithSuccess(___('alert.Email verification link has been sent to your email'), [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.Something went wrong'), [], 400);
        }
    }

    public function sendMobileVerification()
    {
        try {
            $user = User::find(auth()->user()->id);
            $user->token = mt_rand(1111,9999);
            $user->save();
            $this->SendSignupOTP(___('alert.Your_OTP_Code_is') . $user->token . ___('This_Code_will_expire_in_15_minutes'), $user->phone);
            return $this->responseWithSuccess(___('alert.OTP code has been sent to your mobile'), [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.Something went wrong'), [], 400);
        }
    }
    
    public function verifyOTPForPhoneNumber($request)
    {
        try {
            $user = User::where(['id' => auth()->user()->id, 'token' => $request->otp])->first();
            if ($user) {
                $user->phone_verified_at = now();
                $user->token = null;
                $user->save();
                return $this->responseWithSuccess(___('alert.Phone number has been verified'), [], 200);
            } else {
                return $this->responseWithError(___('alert.The provided OTP is invalid'), [], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.Something went wrong'), [], 400);
        }
    }

    public function verifyEmail($email, $expire)
    {
        try {
            $user = User::query()->firstWhere('email', $email);
            if (!$user) {
                return $this->responseWithError(___('alert.Email not found'), [], 400);
            }
            if ($user->email_verified_at) {
                return $this->responseWithError(___('alert.Email has already been verified'), [], 400);
            }
            // time check by $expire to now time
            if ($expire < strtotime(now())) {
                return $this->responseWithError(___('alert.Token has been expired'), [], 400);
            }
            $user->email_verified_at = now();
            //$user->token = null;
            $user->save();
            session()->forget('resend_email');
            return $this->responseWithSuccess(___('alert.Email has been verified'), [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.Something went wrong'), [], 400);
        }
    }

    public function forgotPassword($request)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $user = User::query()->firstWhere('email', $request->email);

            if (!$user) {
                return $this->responseWithError(___('alert.Email not found'), [], 400);
            }
            $alert = ___('alert.we_have_sent_an_reset_password_link_to_your_email_address');

            try {
                event(new ForgotPasswordEvent($user));
            } catch (\Throwable $th) {
                $alert = ___('alert.Instructor create but please configure SMTP to send email correctly');
            }
            return $this->responseWithSuccess($alert, [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.Something went wrong'), [], 400);
        }
    }

    public function resetPasswordPage($email, $expire)
    {
        try {
            $user = User::query()->firstWhere('email', $email);
            if (!$user) {
                return $this->responseWithError(___('alert.Email not found'), [], 400);
            }
            // time check by $expire to now time
            if ($expire < strtotime(now())) {
                return $this->responseWithError(___('alert.Token has been expired'), [], 400);
            }
            return $this->responseWithSuccess(___('alert.Reset password page'), [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.Something went wrong'), [], 400);
        }
    }
    public function resetPassword($request)
    {
        try {
            $user = User::query()->firstWhere('email', decrypt($request->email));
            if (!$user) {
                return $this->responseWithError(___('alert.Email not found'), [], 400);
            }
            $user->password = Hash::make($request->password);
            $user->token = null;
            $user->save();
            return $this->responseWithSuccess(___('alert.Password has been reset successfully'), [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.Something went wrong'), [], 400);
        }
    }
}
