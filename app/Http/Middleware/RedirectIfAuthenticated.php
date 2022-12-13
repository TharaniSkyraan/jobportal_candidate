<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // User
        if (Auth::guard($guard)->check()) {
            if(Auth::guard($guard)->user()->is_active==1){
                return redirect('/home');
            }
            if(Auth::guard($guard)->user()->is_active==0){
                return redirect('/redirect_user');
            }
        }

        return $next($request);
    }

}
