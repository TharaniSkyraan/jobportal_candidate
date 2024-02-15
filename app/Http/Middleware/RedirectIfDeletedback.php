<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfDeletedback
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
        if(Auth::check()){
            if (!empty(Auth::user()->account_delete_request_at)) {
                Auth::logout();
                return back();
            }
        }
        return $next($request);
    }

}
