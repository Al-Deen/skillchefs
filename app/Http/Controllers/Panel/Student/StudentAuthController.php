<?php

namespace App\Http\Controllers\Panel\Student;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Events\UserEmailVerifyEvent;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\SignupOTPSenderTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Student\Entities\Student;
use App\Http\Requests\frontend\student\SignUpRequest;

class StudentAuthController extends Controller
{
    use ApiReturnFormatTrait, SignupOTPSenderTrait;

    protected $user;
    protected $student;

    public function __construct(User $user, Student $student)
    {
        $this->user = $user;
        $this->student = $student;
    }

    public function signUp()
    {
        try {
            if (auth()->check()) {
                return redirect()->route('home')->with('warning', ___('alert.You are already logged in'));
            }
            $data['title'] = ___('student.Sign Up'); // title
            return view('frontend.auth.sign_up', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function signUpPost(SignUpRequest $request)
    {
        DB::beginTransaction(); // start database transaction
        try {
            if (auth()->check()) {
                return redirect()->route('home')->with('warning', ___('alert.You are already logged in'));
            }
            $user_name = preg_replace('/[^A-Za-z0-9]/', '', Str::slug($request->name, '-'));
            $user = new $this->user;
            $user->name = $request->name;
            $user->username = $user_name . '-' . Str::random(5);
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->role_id = Role::STUDENT;
            $user->status_id = 4;
            if ($user->save()) {
                $user->student()->create();

                $otpVerificationStatus = setting('student_otp_verification');
                // email otp send
                if($otpVerificationStatus === "1" || $otpVerificationStatus === "3"){
                    event(new UserEmailVerifyEvent($user));
                }
                // sms otp send
                if($otpVerificationStatus === "2" || $otpVerificationStatus === "3"){
                    $user->token = mt_rand(1111,9999);
                    $user->save();
                    $this->SendSignupOTP(___('alert.Your_OTP_Code_is') . $user->token . ___('This_Code_will_expire_in_15_minutes'), $request->phone);
                }
                // no verification
                if($otpVerificationStatus === "0"){
                    $user->email_verified_at = now();
                    $user->phone_verified_at = now();
                    $user->save();
                }
                $data['redirect_url'] = route('frontend.signIn');
                DB::commit();
                return $this->responseWithSuccess(___('alert.Student has been Sign Up successfully.'), $data);
            }
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response

        }
    }
}
