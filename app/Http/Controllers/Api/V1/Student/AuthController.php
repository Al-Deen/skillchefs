<?php

namespace App\Http\Controllers\Api\V1\Student;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Events\ForgotPasswordEvent;
use Illuminate\Support\Facades\Log;
use App\Events\UserEmailVerifyEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\SignupOTPSenderTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Student\Entities\Student;
use App\Events\ApiUserEmailVerifyEvent;
use App\Events\UserApiEmailVerifyEvent;
use App\Http\Requests\api\student\SignInRequest;
use App\Http\Requests\api\student\SignUpRequest;
use App\Http\Requests\api\student\VerifyEmailRequest;
use App\Http\Requests\api\student\ResetPasswordRequest;
use App\Http\Requests\api\student\ForgotPasswordRequest;
use App\Http\Requests\api\student\ResendOTPRequest;
use App\Http\Requests\api\student\VerifyPhoneRequest;

class AuthController extends Controller
{
    use ApiReturnFormatTrait, SignupOTPSenderTrait;

    protected $user;
    protected $student;

    public function __construct(User $user, Student $student)
    {
        $this->user             = $user;
        $this->student          = $student;
    }



    public function signUpPost(SignUpRequest $request)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $user               =   new $this->user;
            $user->name         =   $request->name;
            $user->email        =   $request->email ?? '';
            $user->phone        =   $request->phone ?? '';
            $user->password     =   Hash::make($request->password);
            $user->role_id      =   Role::STUDENT;
            $user->email_token  =   mt_rand(1111,9999);
            if ($user->save()) {

                $user->student()->create();

                $otpVerificationStatus = setting('student_otp_verification');
                $message = ___('alert.Registration successfully');
                // email otp send
                if($otpVerificationStatus === "1" || $otpVerificationStatus === "3"){
                    event(new ApiUserEmailVerifyEvent($user));
                    $message = ___('alert.Registration successfully, Please verify your email');
                }
                // sms otp send
                // if($otpVerificationStatus === "2" || $otpVerificationStatus === "3"){
                //     $user->token = mt_rand(1111,9999);
                //     $user->save();
                //     $this->SendSignupOTP(___('alert.Your_OTP_Code_is') . $user->token . ___('This_Code_will_expire_in_15_minutes'), $request->phone);
                //     $message = ___('alert.Registration successfully, Please verify your phone number');
                // }
                // no verification
                if($otpVerificationStatus === "0"){
                    $user->email_verified_at = now();
                    $user->phone_verified_at = now();
                    $user->save();
                    $message = ___('alert.Registration successfully');
                }

                $data['user']   = $user;
                $data['token']  = $user->createToken('auth_token')->plainTextToken;
                $data['verification_setup'] = verificationSetup();
                DB::commit();
                return $this->responseWithSuccess($message, $data);
            }
        }

        catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response

        }
    }

    public function signInPost(SignInRequest $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $column = "email";
        } else{
            $column = "phone"; 
        }
        try {
            $verify = $this->user->query()->where($column, $request->email)->first();
            $verification = Setting('student_otp_verification');
            if($column == "email" && $verify && ($verification === "1" || $verification === "3")){
                if (empty($verify->email_verified_at)) {
                    return $this->responseWithError(___('student.Please verify your email address!!'));
                }
            }
            if($column == "phone" && $verify && ($verification === "2" || $verification === "3")){
                if (empty($verify->phone_verified_at)) {
                    return $this->responseWithError(___('student.Please verify your phone number!!'));
                }
            }
            $remember_me = $request->has('remember_me') ? true : false;
            if (Auth::attempt([$column => $request->email, 'password' => $request->password], $remember_me)) {

                $user   = new UserResource($this->user->where($column, $request->email)->first());
                $data['user']   = $user;
                $data['token']  = $user->createToken('auth_token')->plainTextToken;

                return $this->responseWithSuccess(___('alert.successfully Logged in'), $data);
            }

            return $this->responseWithError(___('alert.Invalid login details'), [], 400); // return error response

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }


    public function verifyEmail(VerifyEmailRequest $request)
    {

        try {
            $user   = $this->user->where(['email' => $request->email,'email_token' => $request->code])->first();

            if (!$user) {
                return $this->responseWithError(___('student.invalid_email_address_or_code')); // return error response
            }

            if ($user->email_verified_at) {
                return $this->responseWithSuccess(___('student.your_email_has_already_been_verified_please_login'));
            }

            $user->email_verified_at = now();
            $user->email_token = null;
            if ($user->save()) {
                return $this->responseWithSuccess(___('student.your_email_has_been_verified_please_login'));
            }
        } catch (\Throwable $th) {
            return $this->responseWithSuccess(___('alert.something_went_wrong_please_try_again'));
        }
    }



    public function verifyPhone(VerifyPhoneRequest $request)
    {

        try {
            $user   = $this->user->where(['phone' => $request->phone,'token' => $request->code])->first();

            if (!$user) {
                return $this->responseWithError(___('student.invalid_phone_number_or_code')); // return error response
            }

            if ($user->phone_verified_at) {
                return $this->responseWithSuccess(___('student.your_phone_number_has_already_been_verified_please_login'));
            }

            $user->phone_verified_at = now();
            $user->token = null;
            if ($user->save()) {
                return $this->responseWithSuccess(___('student.your_phone_number_has_been_verified_please_login'));
            }
        } catch (\Throwable $th) {
            return $this->responseWithSuccess(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function resentOTPForPhone(ResendOTPRequest $request){
        try {
            $user   = $this->user->where(['phone' => $request->phone])->first();
            if (!$user) {
                return $this->responseWithError(___('student.invalid_phone_number'));
            }
            $otpVerificationStatus = setting('student_otp_verification');
            if($otpVerificationStatus === "2" || $otpVerificationStatus === "3"){
                $user->token = mt_rand(1111,9999);
                $user->save();
                $this->SendSignupOTP(___('alert.Your_OTP_Code_is') . $user->token . ___('This_Code_will_expire_in_15_minutes'), $request->phone);
                return $this->responseWithSuccess(___('student.we_have_sent_a_reset_OTP_Code_to_your_phone_number'));
            }
        } catch (\Throwable $th) {
            return $this->responseWithSuccess(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

        try {
            $user = $this->user->query()->firstWhere('email', $request->email);

            if (!$user) {
                return $this->responseWithError(___('student.invalid_email_address')); // return error response
            }

            $user->token             = mt_rand(1111,9999);
            if ($user->save()) {
                event(new ForgotPasswordEvent($user));
                return $this->responseWithSuccess(___('student.we_have_sent_an_reset_OTP_Code_to_your_email_address'));
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function verifyOTP(VerifyEmailRequest $request)
    {

        try {
            $user   = $this->user->where(['email' => $request->email,'email_token' => $request->code])->first();

            if (!$user) {
                return $this->responseWithError(___('student.invalid_email_address_or_code')); // return error response
            }

            return $this->responseWithSuccess(___('student.OTP verified successfully!!'));


        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function resetPassword(ResetPasswordRequest $request)
    {

        try {
            $user = $this->user->query()->where(['email' => $request->email])->first();

            if (!$user) {
                return $this->responseWithError(___('student.invalid_email_address')); // return error response
            }

            $user->password = Hash::make($request->password);
            $user->token    = null;

            if ($user->save()) {
                return $this->responseWithError( ___('student.Password Reset successfully!!'));
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
}
