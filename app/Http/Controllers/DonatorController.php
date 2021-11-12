<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Campaign;

class DonatorController extends Controller
{

    public function home()
    {
        return view('frontend.home');
    }

    public function listProject()
    {
        $campaigns = Campaign::all();
        return view('donator.list_project',compact('campaigns'));
    }

    public function profile()
    {
        return view('layouts.profile');
    }

    public function specificProject(String $blockchainAddress){
        return view('donator.specific_project');
    }
    
    public function campaignDetail()
    {
        return view('campaign.campaign_detail');
    }

    public function listDonator()
    {
        return view('campaign.list_donator');
    }
}
