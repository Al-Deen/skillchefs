<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\Role;
use Illuminate\Http\Request;

class AdminMiddleware
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
        if ((auth()->check()) && (auth()->user()->role_id != Role::STUDENT && auth()->user()->role_id != Role::INSTRUCTOR && auth()->user()->role_id != Role::ORGANIZATION)) {
            return $next($request);
        }else if ((auth()->check()) && (auth()->user()->role_id == Role::INSTRUCTOR)) {
            return redirect('instructor/dashboard')->with('error', ___('alert.You are not authorized to access this page'));
        } else if ((auth()->check()) && (auth()->user()->role_id == Role::STUDENT)) {
            return redirect('student/dashboard')->with('error', ___('alert.You are not authorized to access this page'));
        } else if ((auth()->check()) && (auth()->user()->role_id == Role::ORGANIZATION)) {
            return redirect('organization/dashboard')->with('error', ___('alert.You are not authorized to access this page'));
        }
        return redirect('admin/login');
    }
}
