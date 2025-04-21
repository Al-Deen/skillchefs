<?php

namespace Modules\Organization\Http\Middleware;

use Closure;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ((auth()->check()) && (auth()->user()->role_id == Role::ORGANIZATION)) {
            if(auth()->user()->status_id == 5){
                Auth::logout();
            } else{
                return $next($request);
            }
        }
        return redirect()->route('frontend.signIn');
    }
}
