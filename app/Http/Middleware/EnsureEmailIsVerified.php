<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        $verification = 0;
        if($request->user()->role->id === 4){
            // student
            $verification = Setting('student_otp_verification');
        } elseif($request->user()->role->id === 5){
            // instructor
            $verification = Setting('instructor_otp_verification');
        } else{
            // organization
            $verification = "1";
        }
        
        if($verification != "0" && ($verification == "1" || $verification == "3")){
            if (! $request->user() || ($request->user() instanceof MustVerifyEmail && ! $request->user()->hasVerifiedEmail())) {
                return $request->expectsJson()
                        ? abort(403, 'Your email address is not verified.')
                        : Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
            }
        }
        return $next($request);
    }
}
