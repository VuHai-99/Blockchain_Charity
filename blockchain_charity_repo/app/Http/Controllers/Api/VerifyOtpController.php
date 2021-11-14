<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VerifyOtpController extends Controller
{
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
}
