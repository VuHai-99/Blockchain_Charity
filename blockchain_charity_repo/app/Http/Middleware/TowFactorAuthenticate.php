<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TowFactorAuthenticate
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
        if (!Auth::check()) {
            return redirect(route('login'));
        }

        $user = auth()->user();
        if (auth()->check() && $user->otp_verified_at) {
            if (Carbon::parse($user->otp_expires_at)->lt(now())) {
                $user->resetOtp();
                Auth::logout();
                return redirect(route('login'))->with('notify_otp', 'Mã OTP của bạn đã hết hạn, vui lòng đăng nhập lại.');
            }
        }
        if (Auth::check() && !$user->otp_verified_at) {
            return redirect(route('verify.otp.index'));
        }
        return $next($request);
    }
}
