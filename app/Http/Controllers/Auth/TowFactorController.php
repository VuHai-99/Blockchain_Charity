<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Mail\SendMailOtp;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TowFactorController extends Controller
{

    public function sendOtp(LoginRequest $request)
    {
        $data = $request->only('email', 'password');
        if (!Auth::attempt($data)) {
            return back()->with('error-login', 'Email hoặc mật khẩu không đúng. Vui lòng kiểm tra lại.')->withInput();
        }
        $user = Auth::user();
        $otp = $user->generateOtp();
        Mail::to($user->email)->send(new SendMailOtp($otp));
        return redirect(route('verify.otp.index'));
    }
    public function redirectFormConfirmOtp()
    {
        return view('auth.verify_otp');
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->otp;
        $user = Auth::user();
        $expireAt = Carbon::parse($user->otp_expires_at);
        if ($expireAt->lt(now())) {
            $user->resetOtp();
            Auth::logout();
            return redirect(route('login'))->with('notify', 'Mã OTP của bạn đã hết hạn, vui lòng đăng nhập lại.');
        }
        if ($user->role == 1) {
            return redirect(route('host.list.project'));
        } else {
            return redirect(route('donator.list.project'));
        }
    }

    public function reSendMailOtp()
    {
        $user = Auth::user();
        $otp = $user->generateOtp();
        Mail::to($user->email)->send(new SendMailOtp($otp));
        return back();
    }

    public function redirectWhenErrorOtp()
    {
        Auth::user()->resetOtp();
        Auth::logout();
        return redirect(route('login'));
    }
}