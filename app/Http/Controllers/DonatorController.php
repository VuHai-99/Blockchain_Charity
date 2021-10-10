<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonatorController extends Controller
{
    public function index()
    {
        return view('donator.index');
    }

    public function profile()
    {
        return view('layouts.profile');
    }
}