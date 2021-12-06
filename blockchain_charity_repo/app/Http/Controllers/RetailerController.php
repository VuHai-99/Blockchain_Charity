<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetailerController extends Controller
{
    public function __construct()
    {
        $this->middleware('retailer')->except('login', 'validateRetailer');
    }

    public function login()
    {
        return view('retailer.login');
    }

    public function validateRetailer(LoginRequest $request)
    {
        $notification = array(
            'message' => 'Login Successfully',
            'alert-type' => 'success'
        );

        $validate = $request->only('email', 'password');
        if (!Auth::guard('retailer')->attempt($validate)) {
            return back()->with('error-login', 'Email hoặc mật khẩu không đúng. Vui lòng kiểm tra lại.')->withInput();
        } else {
            return 1;
        }
    }
}