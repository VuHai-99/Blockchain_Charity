<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendMailOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyOtpController extends Controller
{
    public function sendOtp()
    {
        $user = Auth::user();
        $otp = $user->generateOtp();
        Mail::to($user->email)->send(new SendMailOtp($otp));
        return response()->json([
            "status" => 200,
            "otp" => $otp
        ], 200);
    }

    public function verify(Request $request)
    {
        $user = Auth::user();
        $otp = $request->otp;
        $check = 0;
        if ($user->otp_code != $otp) {
            $check = 1;
        } else {
            $user->otp_verified_at = now()->format('Y-m-d H:i:s');
            $user->save();
        }
        return response()->json([
            'status' => $check,
            'code' => $otp,
        ]);
    }

    public function confirmPassword(Request $request)
    {
        if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->password])) {
            return response()->json([
                'status' => 200,
                'check' => true,
                'data' => $request->all()
            ]);
        }
        return response()->json([
            'status' => 200,
            'check' => false,
            'data' => $request->all()
        ]);
    }
}