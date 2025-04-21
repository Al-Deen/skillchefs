<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class EnsurePhoneNumberIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = 'verification.notice')
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
        if($verification != "0" && ($verification == "2" || $verification == "3")){
            if (Auth::check() && is_null(Auth::user()->phone_verified_at)) {
                return $request->expectsJson()
                    ? abort(403, 'Your phone number is not verified.')
                    : Redirect::guest(URL::route($redirectToRoute));
            }
        }
        return $next($request);
    }
}
