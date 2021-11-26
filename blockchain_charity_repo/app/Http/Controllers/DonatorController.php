<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Campaign;
use Illuminate\Support\Facades\Http;
use App\Model\Transaction;
use Illuminate\Support\Facades\Auth;

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

    public function WS_donateToCampaign(Request $request){
        $notification = array(
            'message' => 'Donate Successfully',
            'alert-type' => 'success'
        );
        $campaign_address = $request->campaign_address;
        $donateAPI = 'http://localhost:3000/donator/donate/campaign/';
        $donateAPI.=$campaign_address;

        $response = Http::post($donateAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'donator_address' => Auth::user()->user_address,
            'amoutOfEthereum' => $request->donation_amount, 
        ]);
        if($response->status() == 200){
            $transaction_info = $response->json();
            $requestToValidateHost = new Transaction();
            $requestToValidateHost->transaction_hash = $transaction_info['transactionHash'];
            $requestToValidateHost->sender_address = $transaction_info['from'];
            $requestToValidateHost->receiver_address = $transaction_info['to'];
            $requestToValidateHost->transaction_type = 0;
            $requestToValidateHost->amount = $request->donation_amount;
            $requestToValidateHost->save();
            // return redirect()->back()->with($notification);

            $currentCampaign = Campaign::findOrFail($campaign_address);
            $currentCampaign->current_balance = strval(gmp_add($currentCampaign->current_balance, $request->donation_amount));
            $currentCampaign->save();

            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Donate Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
