<?php

namespace App\Http\Controllers\Panel\Student;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\ForgotPasswordEvent;
use App\Events\UserEmailVerifyEvent;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Student\Entities\Student;
use App\Http\Requests\frontend\student\SignInRequest;
use App\Http\Requests\frontend\student\SignUpRequest;
use App\Http\Requests\frontend\student\ResetPasswordRequest;

class AuthController extends Controller
{
    use ApiReturnFormatTrait;

    protected $user;
    protected $student;

    public function __construct(User $user, Student $student)
    {
        $this->user             = $user;
        $this->student          = $student;
    }



    public function signUp()
    {
        try {
            $data['title']      = ___('student.Sign Up'); // title

            return view('panel.student.auth.sign_up', compact('data'));
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }




    public function signUpPost(SignUpRequest $request)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $user               =   new $this->user;
            $user->name         =   $request->name;
            $user->email        =   $request->email;
            $user->phone        =   $request->phone;
            $user->password     =   Hash::make($request->password);
            $user->role_id      =   Role::STUDENT;
            if ($user->save()) {
                $user->student()->create();
                event(new UserEmailVerifyEvent($user));
                $data['redirect_url'] = route('student.sign_in');

                DB::commit();
                return $this->responseWithSuccess(___('alert.Student has been Sign Up successfully.'), $data);
            }
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response

        }
    }


    public function signIn()
    {
        try {
            $data['title']      = ___('student.Sign In'); // title

            return view('panel.student.auth.sign_in', compact('data'));
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function signInPost(SignInRequest $request)
    {

        try {
            $verify = $this->user->query()->where('email', $request->email)->first()->email_verified_at;

            if (empty($verify)) {
                $data['redirect_url'] = route('student.sign_in');
                return $this->responseWithSuccess(___('student.Please verify your email address!!'), $data);
            }

            $remember_me = $request->has('remember_me') ? true : false;

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
                $data['redirect_url'] = route('student.dashboard');
                return $this->responseWithSuccess(___('alert.successfully Logged in'), $data);
            }

            return $this->responseWithError(___('alert.Invalid login details'), [], 400); // return error response

        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response

        }
    }


    public function verifyEmail($email)
    {

        try {
            $user = $this->user->query()->firstWhere('email', $email);

            if (!$user) {
                return redirect()->route('student.sign_in')->with('danger',  ___('student.invalid_email_address'));
            }

            if ($user->email_verified_at) {
                return redirect()->route('student.sign_in')->with('success',  ___('student.your_email_has_already_been_verified_please_login'));
            }

            $user->email_verified_at = now();
            if ($user->save()) {
                return redirect()->route('student.sign_in')->with('success',  ___('student.your_email_has_been_verified_please_login'));
            }
        } catch (\Throwable $th) {
            return back()->with('danger',  ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function forgotPassword()
    {
        try {
            $data['title']      = ___('student.Forgot Password'); // title

            return view('panel.student.auth.forgot_password', compact('data'));
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function forgotPasswordPost(Request $request)
    {

        try {
            $user = $this->user->query()->firstWhere('email', $request->email);

            if (!$user) {
                return redirect()->route('student.forgot_password')
                    ->with('danger',  ___('student.invalid_email_address'))
                    ->withInput($request->all());
            }

            $user->token             = Str::random(30);
            if ($user->save()) {
                event(new ForgotPasswordEvent($user));
                return redirect()->route('student.forgot_password')->with('success',  ___('student.we_have_sent_an_reset_password_link_to_your_email_address'));
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
                return redirect()->route('student.forgot_password')->with('danger',  ___('student.invalid_email_address'));
            }

            $data['title']      = ___('student.Reset Password'); // title

            return view('panel.student.auth.reset_password', compact('data'));
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
            $user->token    = null;

            if ($user->save()) {
                return redirect()->route('student.sign_in')->with('success',  ___('student.Password Reset successfully!!'));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
