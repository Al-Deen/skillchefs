<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\Role;
use Illuminate\Support\Facades\Auth;

class AmbassadorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ((auth()->check()) && (auth()->user()->role_id == Role::Ambassador)) {
            if(auth()->user()->status_id == 5){
                Auth::logout();
            }else{
                return $next($request);
            }
        }
        return redirect()->route('frontend.signIn');
    }
}
