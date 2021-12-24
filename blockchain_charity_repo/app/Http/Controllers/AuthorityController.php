<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorityController extends Controller
{
    public function __construct()
    {
        $this->middleware('authority')->except('login', 'validateAuthority', 'logout');
    }

    public function login()
    {
        return view('authority.login');
    }

    public function logout()
    {
        Auth::guard('authority')->logout();
        return view('authority.login');
    }

    public function validateAuthority(LoginRequest $request)
    {
        $notification = array(
            'message' => 'Login Successfully',
            'alert-type' => 'success'
        );

        $validate = $request->only('email', 'password');
        if (!Auth::guard('authority')->attempt($validate)) {
            return back()->with('error-login', 'Email hoặc mật khẩu không đúng. Vui lòng kiểm tra lại.')->withInput();
        } else {
            return redirect()->route('authority.index')->with($notification);
        }
    }

    public function index()
    {
        return view("authority.index");
    }

    public function listDonationActivityCashoutRequest()
    {
        return view('authority.list_donation_activity_cashout_request');
    }

    public function listDonationActivityOrderRequest()
    {
        return view('authority.list_donation_activity_order_request');
    }
    
}