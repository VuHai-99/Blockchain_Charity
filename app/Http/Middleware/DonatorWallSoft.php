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
        if (!Auth::check() || Auth::user()->wallet_type != EnumUser::DONATOR_WALLET_SOFT) {
            return redirect(route('home'));
        }
        return $next($request);
    }
}