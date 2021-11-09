<?php

namespace App\Http\Controllers;

use App\Model\Project;
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

    public function storeProject(Request $request)
    {
        $new_project = new Project();
        // $new_project->name = $request->name;
        // $new_project->minimum_contribution = $request->minimum_contribution;
        // $new_project->description = 'Project Initial Description';
        // $new_project->host_address = '1';
        // $new_project->current_balance = '0';
        // $new_project->date_started = $request->date_started;
        // $new_project->date_end = $request->date_end;
        // $new_project->contract_address = $request->contract_address;

        $new_project->name = 'ProjectName';
        $new_project->minimum_contribution = '100';
        $new_project->description = 'Project Initial Description';
        $new_project->host_address = '0x001';
        $new_project->current_balance = '0';
        $new_project->date_started ='10/10/2021';
        $new_project->date_end = '10/11/2021';
        $new_project->contract_address = '0x002';
        
        $new_project->save();
    }

    public function campaignDetail()
    {
        return view('campaign.campaign_detail');
    }
}
