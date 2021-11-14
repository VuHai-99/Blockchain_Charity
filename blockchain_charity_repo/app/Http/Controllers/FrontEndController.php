<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function home()
    {
        return view('frontEnd.home');
    }

    public function campaign()
    {
        return view('frontEnd.campaign');
    }

    public function detail($id)
    {
        return view('frontEnd.campaign_detail');
    }
}