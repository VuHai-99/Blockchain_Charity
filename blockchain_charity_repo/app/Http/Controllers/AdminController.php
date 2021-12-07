<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class AdminController extends Controller
{
    protected $redirectTo = '/admin';
    protected $guard = 'admin';

    public function login()
    {
        return view('admin.login');
    }

    public function logout()
    {
        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'success'
        );
        Auth::guard('admin')->logout();
        return redirect(route('home'))->with($notification);
    }

    public function verify(LoginRequest $request)
    {
        $notification = array(
            'message' => 'Login Successfully',
            'alert-type' => 'success'
        );
        $data = $request->only('email', 'password');
        if (!Auth::guard('admin')->attempt($data)) {
            return back()->with('error-login', 'Email hoặc mật khẩu không đúng. Vui lòng kiểm tra lại.')->withInput();
        } else {
            return redirect()->route('admin.dashboard.index')->with($notification);
        }
    }
    
    public function index()
    {
        return view('admin.index');
    }

    public function listCampaign()
    {
        return view('admin.list_campaign');
    }

    public function listOpenCampaignRequest(){
        return view('admin.list_open_campaign_request');
    }   

    public function listValidateHostRequest(){
        return view('admin.list_validate_host_request');
    }

    public function listWithdrawMoneyRequest(){
        return view('admin.list_withdraw_money_request');
    }
    

    public function listHost()
    {
        $users = User::all();
        return view('admin.list_host',compact('users'));
    }

    public function listcreateDonationActivityRequest(){
        return view('admin.list_create_donationActivity_request');
    }
}
