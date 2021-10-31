<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function home()
    {
        return view('frontEnd.home');
    }

    public function events()
    {
        return view('frontEnd.events');
    }

    public function detail($id)
    {
        return view('frontEnd.project_detail');
    }
}
