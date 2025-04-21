<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Enums\Role;
use App\Events\ForgotPasswordEvent;
use App\Events\UserEmailVerifyEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\frontend\instructor\StepOneRequest;
use App\Http\Requests\frontend\instructor\StepThreeRequest;
use App\Http\Requests\frontend\instructor\StepTwoRequest;
use App\Http\Requests\frontend\student\ResetPasswordRequest;
use App\Http\Requests\frontend\student\SignInRequest;
use App\Models\Instructor;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use ApiReturnFormatTrait, FileUploadTrait;

    protected $instructor;
    protected $user;

    public function signIn()
    {
        try {
            $data['title'] = ___('instructor.Sign In'); // title

            return view('panel.instructor.auth.sign_in', compact('data'));
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function verifyEmail($email)
    {

        try {
            $user = $this->user->query()->firstWhere('email', $email);

            if (!$user) {
                return redirect()->route('frontend.signIn')->with('danger', ___('student.invalid_email_address'));

            }

            if ($user->email_verified_at) {
                return redirect()->route('frontend.signIn')->with('success', ___('student.your_email_has_already_been_verified_please_login'));

            }

            $user->email_verified_at = now();
            if ($user->save()) {
                return redirect()->route('frontend.signIn')->with('success', ___('student.your_email_has_been_verified_please_login'));
            }

        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function forgotPassword()
    {
        try {
            $data['title'] = ___('instructor.Forgot Password'); // title

            return view('panel.instructor.auth.forgot_password', compact('data'));
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function forgotPasswordPost(Request $request)
    {

        try {
            $user = $this->user->query()->firstWhere('email', $request->email);

            if (!$user) {
                return redirect()->route('instructor.forgot_password')
                    ->with('danger', ___('student.invalid_email_address'))
                    ->withInput($request->all());
            }

            $user->token = Str::random(30);
            if ($user->save()) {
                event(new ForgotPasswordEvent($user));
                return redirect()->route('instructor.forgot_password')->with('success', ___('student.we_have_sent_an_reset_password_link_to_your_email_address'));
            }

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function resetPassword($email, $token)
    {
        try {
            $user = $this->user->query()->firstWhere('email', $email);

            if (!$user) {
                return redirect()->route('instructor.forgot_password')->with('danger', ___('student.invalid_email_address'));

            }

            $data['title'] = ___('instructor.Reset Password'); // title

            return view('panel.instructor.auth.reset_password', compact('data'));

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }
    public function resetPasswordPost(ResetPasswordRequest $request)
    {

        try {
            $user = $this->user->query()->where(['email' => $request->email])->first();

            if (!$user) {
                return redirect()->back()->with('danger', ___('student.invalid_email_address'));
            }

            $user->password = Hash::make($request->password);
            $user->token = null;

            if ($user->save()) {
                return redirect()->route('frontend.signIn')->with('success', ___('student.Password Reset successfully!!'));
            }

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }
}
