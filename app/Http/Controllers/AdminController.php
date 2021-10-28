<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        Auth::guard('admin')->logout();
        return redirect(route('home'));
    }

    public function verify(LoginRequest $request)
    {
        $data = $request->only('email', 'password');
        if (!Auth::guard('admin')->attempt($data)) {
            return back()->with('error-login', 'Email hoặc mật khẩu không đúng. Vui lòng kiểm tra lại.')->withInput();
        } else {
            return redirect(route('admin.dashboard.index'));
        }
    }
    
    public function index()
    {
        return view('admin.index');
    }

    public function listProject()
    {
        return view('admin.list_project');
    }

    public function listHost()
    {
        return view('admin.list_host');
    }
}
