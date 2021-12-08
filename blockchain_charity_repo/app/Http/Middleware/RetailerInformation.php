<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RetailerInformation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'retailer')
    {

        if (!Auth::guard($guard)->check()) {
            return redirect(route('retailer.login'));
        }
        return $next($request);
    }
}