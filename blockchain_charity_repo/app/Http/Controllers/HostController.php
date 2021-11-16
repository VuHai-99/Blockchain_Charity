<?php

namespace App\Http\Controllers;

use App\Model\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }
    
    public function listCampaign()
    {
        $campaigns = Campaign::all();
        // dd($campaigns);
        return view('host.list_campaign',compact('campaigns'));
    }

    public function createCampaign()
    {
        return view('host.create_campaign');
    }

    // public function listMyProject(){
    //     return view('host.list_my_project');
    // }

    // public function specificProject(String $blockchainAddress){
    //     return view('host.specific_project');
    // }

    public function validateHost(){
        return view('host.validate_host');
    }

    public function campaignDetail($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        return view('host.campaign_detail',compact('campaign'));
    }

    //WS
    public function WS_listCampaign(){
        $campaigns = Campaign::all();
        // dd($campaigns);
        return view('host.list_campaign_ws',compact('campaigns'));
    }

    public function WS_campaignDetail($blockchainAddress){
        $campaign = Campaign::findOrFail($blockchainAddress);
        return view('host.campaign_detail_ws',compact('campaign'));
    }

    public function WS_validateHost(){
        $host = Auth::user();
        return view('host.validate_host_ws',compact('host'));
    }

    public function WS_createCampaign(){
        return view('host.create_campaign_ws');
    }
}
