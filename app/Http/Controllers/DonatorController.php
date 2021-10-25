<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonatorController extends Controller
{
    public function listProject()
    {
        return view('donator.list_project');
    }

    public function profile()
    {
        return view('layouts.profile');
    }
}