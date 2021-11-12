<?php

namespace App\Http\Controllers;

use App\Model\Campaign;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }
    
    public function listProject()
    {
        return view('host.list_project');
    }

    public function createProject()
    {
        return view('host.create_project');
    }

    public function listMyProject(){
        return view('host.list_my_project');
    }

    public function specificProject(String $blockchainAddress){
        return view('host.specific_project');
    }

    public function validateHost(){
        return view('host.validate_host');
    }

    public function campaignDetail()
    {
        return view('campaign.campaign_detail');
    }
}
