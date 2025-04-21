<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Interfaces\AuthenticationRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AuthenticationController extends Controller
{
    private $loginRepository;

    public function __construct(AuthenticationRepositoryInterface $loginRepository)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')) {

            Artisan::call('migrate:fresh', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
        }
        $this->loginRepository = $loginRepository;

    }

    public function loginPage()
    {
        $data['title'] = "Login";
        return view('backend.auth.login', compact('data'));
    }

    public function login(LoginRequest $request)
    {
        $email = $request->safe()->only(['email']);
        $password = $request->safe()['password'];

        $user = User::query()->firstWhere('email', $email);

        if (!$user) {
            return back()->withErrors([
                'email' => ___('users_roles.the_provided_email_do_not_match_our_records'),
            ]);
        }

        if (!Hash::check($password, $user->password)) {
            return back()->withErrors([
                'password' => ___('users_roles.the_provided_password_does_not_match_our_records'),
            ]);
        }
        if(Setting('student_otp_verification') === "1" || Setting('student_otp_verification') === "3"){
            if ($user->email_verified_at == null) {
                return back()->with('danger', ___('users_roles.account_not_verified_yet'));
            }
        }

        if ($user->status == 0) {
            return back()->with('danger', ___('users_roles.you_are_inactive'));
        }
        if ($user->role->status == 0) {
            return back()->with('danger', ___('users_roles.this_user_role_is_inactive'));
        }

        if ($this->loginRepository->login($request->all())) {
            if (Auth::user()->status_id == 5) {
                Auth::logout();
                return back()->with('danger', ___('alert.Your account has been suspended'));
            }
            return redirect()->route('dashboard');
        }

        return back()->with('danger', ___('users_roles.something_went_wrong_please_try_again'));

    }

    public function registerPage()
    {
        $data['title'] = "Create Account";
        return view('backend.auth.register', compact('data'));
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->loginRepository->register($request);

        if ($user) {
            return redirect()->route('login')->with('success', ___('users_roles.we_have_send_you_an_email_please_verify_your_email_address'));
        }

        return back()->with('danger', ___('users_roles.something_went_wrong_please_try_again'));
    }

    public function verifyEmail($email, $token)
    {
        $result = $this->loginRepository->verifyEmail($email, $token);

        if ($result == 'success') {
            return redirect()->route('login')->with('success', ___('users_roles.your_email_has_been_verified_please_login'));
        } elseif ($result == 'already_verified') {
            return redirect()->route('login')->with('success', ___('users_roles.your_email_has_already_been_verified_please_login'));
        } elseif ($result == 'invalid_email') {
            return redirect()->route('login')->with('danger', ___('users_roles.invalid_email_address'));
        } elseif ($result == 'invalid_token') {
            return redirect()->route('login')->with('danger', ___('users_roles.invalid_token'));
        } else {
            return redirect()->route('login')->with('danger', ___('users_roles.something_went_wrong_please_try_again'));
        }
    }

    public function logout(Request $request)
    {
        $this->loginRepository->logout();
        return redirect()->route('login');
    }

    public function forgotPasswordPage()
    {
        $data['title'] = "Forgot Password";
        return view('backend.auth.forgot-password', compact('data'));
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $result = $this->loginRepository->forgotPassword($request);
            if ($result->original['result']) {
                return back()->with('success', ___('users_roles.we_have_sent_an_reset_password_link_to_your_email_address'));
            } else {
                return back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('users_roles.something_went_wrong_please_try_again'));
        }
    }

    public function resetPasswordPage($email, $token)
    {
        $result = $this->loginRepository->resetPasswordPage($email, $token);

        if ($result == 'success') {

            $data['title'] = "Reset Password";
            $data['email'] = $email;
            $data['token'] = $token;

            return view('backend.auth.reset-password', compact('data'));

        } elseif ($result == 'invalid_email') {
            return redirect()->route('login')->with('danger', ___('users_roles.invalid_email_address'));
        } elseif ($result == 'invalid_token') {
            return redirect()->route('login')->with('danger', ___('users_roles.invalid_token'));
        } else {
            return redirect()->route('login')->with('danger', ___('users_roles.something_went_wrong_please_try_again'));
        }

    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $result = $this->loginRepository->resetPassword($request);

            if ($result->original['result']) {
                return redirect()->route('login')->with('success', ___('users_roles.your_password_has_been_reset_please_login'));
            } else {
                return back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('users_roles.something_went_wrong_please_try_again'));
        }
    }

}
