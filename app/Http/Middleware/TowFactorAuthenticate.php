<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

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
        $user = auth()->user();

        if (auth()->check() && $user->code_otp) {
            if (Carbon::parse($user->otp_expires_at)->lt(now())) {
                $user->resetOtp();
                Auth::logout();

                return redirect()->route('login')->with('notify-login', 'The two factor code has expired. Please login again.');
            }
            if (!$request->is('verify*')) {
                return redirect()->route('verify.otp.index');
            }
        }

        return $next($request);
    }
}
