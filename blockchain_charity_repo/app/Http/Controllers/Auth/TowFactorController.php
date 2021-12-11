<?php

namespace App\Http\Controllers\Auth;

use App\Enums\EnumUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Mail\SendMailOtp;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        // Mail::to($user->email)->send(new SendMailOtp($otp));

        Auth::guard('authority')->logout();
        Auth::guard('admin')->logout();
        if ($user->role == 1) {
            return redirect(route('host.home'));
        }
        return redirect(route('donator.home'));
    }

    public function redirectFormConfirmOtp()
    {
        return view('auth.verify_otp');
    }

    public function verifyOtp(Request $request)
    {
        $notification = array(
            'message' => 'Login Successfully',
            'alert-type' => 'success'
        );
        $otp = $request->otp;
        $user = Auth::user();
        $expireAt = Carbon::parse($user->otp_expires_at);
        if ($expireAt->lt(now())) {
            $user->resetOtp();
            Auth::logout();
            return redirect(route('login'))->with('notify', 'Mã OTP của bạn đã hết hạn, vui lòng đăng nhập lại.');
        }
        if ($user->role == EnumUser::ROLE_HOST && $user->wallet_type == EnumUser::WALLET_HARD) {
            return redirect()->route('host.home')->with($notification);
        } else if ($user->role == EnumUser::ROLE_HOST && $user->wallet_type == EnumUser::WALLET_SOFT) {
            return redirect()->route('hostws.home')->with($notification);
        } else if ($user->role == EnumUser::ROLE_DONATOR && $user->wallet_type == EnumUser::WALLET_SOFT) {
            return redirect()->route('donatorws.home')->with($notification);
        } else {
            return redirect()->route('donator.home')->with($notification);
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