<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $redirectTo = '/admin';
    protected $guard = 'admin';

    public function login()
    {
        return 'login';
    }

    public function index()
    {
        return 'index admin';
    }
}
