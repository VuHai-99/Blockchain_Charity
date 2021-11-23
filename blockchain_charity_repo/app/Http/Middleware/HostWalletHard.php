<?php

namespace App\Http\Middleware;

use App\Enums\EnumUser;
use Closure;
use Illuminate\Support\Facades\Auth;

class HostWalletHard
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
        if (Auth::user()->role == EnumUser::ROLE_HOST && Auth::user()->wallet_type == EnumUser::WALLET_HARD) {
            return $next($request);
        }
        return redirect(route('home'));
    }
}
