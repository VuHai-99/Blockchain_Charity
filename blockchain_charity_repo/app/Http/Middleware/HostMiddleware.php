<?php

namespace App\Http\Middleware;

use App\Enums\EnumUser;
use Closure;
use Illuminate\Support\Facades\Auth;

class HostMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == EnumUser::ROLE_HOST) {
            return $next($request);
        }
        return redirect(route('login'));
    }
}