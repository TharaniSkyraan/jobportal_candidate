<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
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
        $api = explode('/',$request->getPathInfo())[1];
        dd($api);
        if($api=='api'){           
            dd(Auth::check());
        }
        if (Auth::check() && Auth::user()->is_active==0) {
            return redirect('/redirect_user');
        }
        return $next($request);
    }

}
