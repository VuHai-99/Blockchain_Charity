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

    public function listCampaign()
    {
        $campaigns = Campaign::all();
        return view('donator.list_campaign',compact('campaigns'));
    }

    public function profile()
    {
        return view('layouts.profile');
    }

    public function specificProject(String $blockchainAddress){
        return view('donator.specific_project');
    }
    
    public function campaignDetail(String $blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        return view('donator.campaign_detail',compact('campaign'));
    }

    //WS 
    public function WS_listCampaign(){
        $campaigns = Campaign::all();
        return view('donator.list_campaign_ws',compact('campaigns'));   
    }

    public function WS_campaignDetail(String $blockchainAddress){
        $campaign = Campaign::findOrFail($blockchainAddress);
        return view('donator.campaign_detail_ws',compact('campaign'));
    }
}
