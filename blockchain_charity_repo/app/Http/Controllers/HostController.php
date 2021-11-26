<?php

namespace App\Http\Controllers;

use App\Model\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Model\Transaction;
use App\Model\BlockchainRequest;

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

    public function WS_donateToCampaign(Request $request){
        
        $campaign_address = $request->campaign_address;
        $donateAPI = 'http://localhost:3000/donator/donate/campaign/';
        $donateAPI.=$campaign_address;

        $response = Http::post($donateAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'donator_address' => Auth::user()->user_address,
            'amoutOfEthereum' => $request->donation_amount, 
        ]);
        if($response->status() == 200){
            $notification = array(
                'message' => 'Donate Successfully',
                'alert-type' => 'success'
            );

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

    public function WS_withdrawCampaign(Request $request){
        $withdrawAPI = 'http://localhost:3000/host/withdraw/campaign/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'validated_host_address' => Auth::user()->user_address,
            'amount_of_money' => $request->withdrawal_amount, 
            "campaign_adress_target" =>  $request->campaign_address
        ]);
        if($response->status() == 200){
            $notification = array(
                'message' => 'Request to Withdraw Money Successfully',
                'alert-type' => 'success'
            );
            $transaction_info = $response->json();
            $requestToWithdrawMoney = new BlockchainRequest();
            $requestToWithdrawMoney->request_id = $transaction_info['request_id'];
            $requestToWithdrawMoney->requested_user_address = $transaction_info['requested_user_address'];
            $requestToWithdrawMoney->amount = $transaction_info['amount'];
            $requestToWithdrawMoney->campaign_address = $request->campaign_address;
            $requestToWithdrawMoney->request_type = 2;
            $requestToWithdrawMoney->save();
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to Withdraw Money Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
