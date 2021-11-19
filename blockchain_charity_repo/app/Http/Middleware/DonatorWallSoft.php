<?php

namespace App\Http\Middleware;

use App\Enums\EnumUser;
use Closure;
use Illuminate\Support\Facades\Auth;

class DonatorWallSoft
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
        if (Auth::user()->role == EnumUser::ROLE_DONATOR && Auth::user()->wallet_type == EnumUser::WALLET_SOFT) {
            return $next($request);
        }
        return redirect(route('home'));
    }
}
