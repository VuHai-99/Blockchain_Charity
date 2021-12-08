<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetailerController extends Controller
{
    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware('retailer')->except('login', 'validateRetailer', 'logout');
        $this->productRepository = $productRepository;
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
            return "sai";

            return back()->with('error-login', 'Email hoặc mật khẩu không đúng. Vui lòng kiểm tra lại.')->withInput();
        } else {
            if (Auth::guard('retailer')->check()) {
                return redirect()->route('retailer.dashboard')->with($notification);
            }
            return "chưa đc";
        }
    }

    public function logout()
    {
        Auth::guard('retailer')->logout();
        return redirect(route('retailer.login'));
    }

    public function index()
    {
        return view('retailer.dashboard');
    }

    public function listProduct()
    {
        $products = $this->productRepository->getAll();
        $comments = [];
    }
}