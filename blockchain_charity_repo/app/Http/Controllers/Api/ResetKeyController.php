<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetKeyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResetKeyController extends Controller
{
    public function changeKey(Request $request)
    {
        $user = Auth::user();
        $user->user_address = $request->public_key;
        $user->save();
        return response()->json([
            'status' => 200,
            'message' => 'Sửa khóa thành công'
        ]);
    }
}