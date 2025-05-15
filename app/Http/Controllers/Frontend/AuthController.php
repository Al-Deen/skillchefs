<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\frontend\OTPRequest;
use App\Http\Requests\frontend\SignInRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Interfaces\AuthenticationRepositoryInterface;
use App\Interfaces\UserInterface;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Laravel\Socialite\Facades\Socialite;
use Modules\Student\Entities\Student;

class AuthController extends Controller
{

    use ApiReturnFormatTrait;

    protected $user;
    protected $authenticationRepository;
    protected $student;

    public function __construct(UserInterface $userInterface, AuthenticationRepositoryInterface $authenticationRepository , Student $student)
    {
        $this->user = $userInterface;
        $this->authenticationRepository = $authenticationRepository;
        $this->student = $student;
    }

    public function signIn()
    {
        if (auth()->check()) {
            if (auth()->user()->phone == null){
                return redirect()->route('student.dashboard');
            }
            return redirect()->route('home')->with('warning', ___('alert.You are already logged in'));
        }
        $data['title'] = ___('auth.Sign In'); // title
        return view('frontend.auth.sign_in', compact('data'));
    }
    // email verification
    public function verifyEmail(Request $request, $email)
    {
        try {
            $result = $this->authenticationRepository->verifyEmail(decrypt($email), $request->expire, );
            if ($result->original['result']) {
                if (auth()->check()) {
                    return redirect()->route('home')->with('success', $result->original['message']);
                }
                return redirect()->route('frontend.signIn')->with('success', $result->original['message']);
            } else {
                return redirect()->route('frontend.signIn')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function forgotPassword()
    {
        try {
            $data['title'] = ___('student.Forgot Password'); // title
            return view('frontend.auth.forgot_password', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function forgotPasswordPost(Request $request)
    {
        try {
            $result = $this->authenticationRepository->forgotPassword($request);
            if ($result->original['result']) {
                return redirect()->route('frontend.forgot_password')->with('success', $result->original['message']);
            } else {
                return redirect()->route('frontend.forgot_password')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function resetPassword(Request $request, $email)
    {
        try {
            $result = $this->authenticationRepository->resetPasswordPage(decrypt($email), $request->expire, );
            if ($result->original['result']) {
                $data['title'] = ___('student.Set New Password'); // title
                $data['email'] = ($email);
                return view('frontend.auth.reset_password', compact('data'));
            } else {
                return redirect()->route('frontend.forgot_password')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function resetPasswordPost(ResetPasswordRequest $request)
    {
        try {
            $result = $this->authenticationRepository->resetPassword($request);
            if ($result->original['result']) {
                return redirect()->route('frontend.signIn')->with('success', $result->original['message']);
            } else {
                return redirect()->route('frontend.forgot_password')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function signInPost(SignInRequest $request)
    {
        try {
            $result = $this->authenticationRepository->panelLogin($request);
            if ($result->original['result']) {
                $user = Auth::user();


                if(Setting('student_otp_verification') === "1" || Setting('student_otp_verification') === "3"){
                    if ($user->email_verified_at == null) {
                        $data['redirect_url'] = route('frontend.signIn');
                        return $this->responseWithError( ___('users_roles.account_not_verified_yet'), $data, 400);
                    }
                }

                if ($user->status == 0) {
                    $data['redirect_url'] = route('frontend.signIn');
                    return $this->responseWithError( ___('users_roles.you_are_inactive'), $data, 400);
                }
                if ($user->role->status == 0) {
                    $data['redirect_url'] = route('frontend.signIn');
                    return $this->responseWithError( ___('users_roles.this_user_role_is_inactive'), $data, 400);
                }
                if (Auth::user()->status_id == 5) {
                    Auth::logout();
                    $data['redirect_url'] = route('frontend.signIn');
                    return $this->responseWithError(___('alert.Your account has been suspended'), $data, 400);
                }
                if(setting('two_fa_setup') === "1"){
                    if(module('TwoFA') && @$user->two_fa){
                        $user_info = [
                            'email' => $user->email,
                            'password' => $request->password
                        ];
                        $two_fa = new \Modules\TwoFA\Repositories\TwoFaRepository(new \App\Models\User, new \App\Models\Setting);
                        $two_fa->SendOTPCode($user->id);
                        Auth::logout();
                        $data['redirect_url'] = route('frontend.two_fa_verification', encrypt($user_info));
                        return $this->responseWithSuccess(___('alert.Please_verify_your_two_factor_authentication'), $data, 200);
                    }
                }

                if ($user->role_id != Role::STUDENT && $user->role_id != Role::INSTRUCTOR && $user->role_id != Role::ORGANIZATION ){
                    $data['redirect_url'] = route('dashboard');
                }elseif ($user->role_id == Role::STUDENT){
                    $data['redirect_url'] = route('student.dashboard');
                }elseif ($user->role_id == Role::INSTRUCTOR){
                    $data['redirect_url'] = route('instructor.dashboard');
                }elseif ($user->role_id == Role::ORGANIZATION){
                    $data['redirect_url'] = route('organization.dashboard');
                }else{
                    $data['redirect_url'] = route('home');
                }
                return $this->responseWithSuccess(___('alert.Successfully Logged in'), $data);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    // email verification

    public function verify(Request $request)
    {
        try {
            if (auth()->user()->email_verified_at != null && auth()->user()->phone_verified_at != null) {
                return redirect()->route('home')->with('success', ___('alert.Email & phone number already verified'));
            }
            $data['email_url'] = route('send.verification.verify', ['type' => 'email', 'id' => encrypt(auth()->user()->email)]) . '?expire=' . strtotime(now()->addMinutes(30));
            $data['otp_url'] = route('send.verification.verify', ['type' => 'otp', 'id' => encrypt(auth()->user()->email)]) . '?expire=' . strtotime(now()->addMinutes(30));
            $data['title'] = ___('auth.Verification'); // title
            $data['email_title'] = ___('auth.Email Verification'); // title
            $data['otp_title'] = ___('auth.Phone Number Verification'); // title
            $data['email_button'] = ___('auth.Send Verification Email'); // title
            $data['otp_button'] = ___('auth.Resend OTP'); // title

            if(auth()->user()->role->id === 4){
                $data['verification'] = Setting('student_otp_verification');    // student
            } elseif(auth()->user()->role->id === 5){
                $data['verification'] = Setting('instructor_otp_verification'); // instructor
            } else{
                $data['verification'] = "1";                                    // organization
            }

            if ($request->session()->has('resend_email')) {
                $data['button'] = ___('auth.Resend Verification Email'); // title
            }
            return view('frontend.auth.email_verify', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function sendVerify(Request $request, $type)
    {
        try {
            if($type === 'email'){    // email verification
                $result = $this->authenticationRepository->sendEmailVerification();
            } else{                   // phone number verification
                $result = $this->authenticationRepository->sendMobileVerification();
            }
            if ($result->original['result']) {
                $data['title'] = ___('auth.Email Verification'); // title
                $request->session()->put('resend_email', true);
                return redirect()->route('verification.notice')->with('success', $result->original['message']);
            } else {
                return redirect()->route('home')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function verifyPhoneNumber(OTPRequest $request){
        try {
            $result = $this->authenticationRepository->verifyOTPForPhoneNumber($request);
            if ($result->original['result']) {
                $data['title'] = ___('auth.Email Verification'); // title
                $request->session()->put('resend_email', true);
                return redirect()->route('home')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function authProviderRedirect($provider) {
        if ($provider) {
            return Socialite::driver($provider)->redirect();
        }
        abort(404);
    }

    public function socialAuthentication($provider) {
        try {
            if ($provider) {
                $socialUser = Socialite::driver($provider)->stateless()->user();
                $user = User::where('google_id', $socialUser->id)->first();
                if ($user) {
                    Auth::login($user);
                } else {
                    $user_name = preg_replace('/[^A-Za-z0-9]/', '', Str::slug($socialUser->name, '-'));
                    $user = User::create([
                        'name' => $socialUser->name,
                        'username' => $user_name . '-' . Str::random(5),
                        'email' => $socialUser->email,
                        'role_id'=> 4,
                        'status'=> 1,
                        'status_id'=> 4,
                       // 'password' => Hash::make(Str::random(6)),
                       // 'password' => Hash::make(12345678),
                        'google_id' => $socialUser->id,
                    ]);
                  Auth::login($user);
                 $user->student()->create();
                }
                return redirect()->route('student.dashboard')->with('success', 'Successfully Logged in');
            }
            abort(404);

        } catch (Exception $e) {
            dd($e);
        }
    }
}
