<?php

namespace App\Http\Controllers;

use App\User;
use App\Model\Campaign;
use App\Model\Transaction;
use App\Model\BlockchainRequest;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Http;
class BlockchainController extends Controller
{
    public function storeCampaign(Request $request)
    {
        $new_campaign = new Campaign();
        $new_campaign->name = $request->name;
        $new_campaign->campaign_address = $request->campaign_address;
        $new_campaign->host_address =$request->host_address;
        $new_campaign->description = $request->description;
        $new_campaign->minimum_contribution = $request->minimum_contribution;
        $new_campaign->target_contribution_amount = $request->target_contribution_amount;
        $new_campaign->current_balance = '0';
        $new_campaign->date_started = $request->date_started;
        $new_campaign->date_end = $request->date_end;

        
        $new_campaign->save();
    }

    //NOTE CHUA TEST 
    public function storeTransaction(Request $request)
    {
        $new_transaction = new Transaction();
        $new_transaction->transaction_hash = $request->transaction_hash;
        $new_transaction->sender_address = $request->sender_address;
        $new_transaction->receiver_address =$request->receiver_address;
        $new_transaction->transaction_type = $request->transaction_type;
        $new_transaction->amount = $request->amount;
        $new_transaction->save();
    }
    
    
    // public function decideBlockchainRequest(Request $request)
    // {
    //     // 0 is valid host, 1 is open campaign, 2 is withdraw money
    //     $request_id = $request->request_id;
    //     $decide_type= $request->decide_type;
    //     $newCampaignAddress = "";
    //     if($request->newCampaignAddress){
    //         $newCampaignAddress = $request->newCampaignAddress;
    //     }
        
    //     $blockchain_request = BlockchainRequest::findOrFail($request_id);
    //     if($blockchain_request){
    //         if($decide_type == 'Accept'){
    //             if($blockchain_request->request_type == 0){
    //                 // valid host request
    //                 $host = User::findOrFail($blockchain_request->requested_user_address);
    //                 $host->validate_state = 2;
    //                 $host->save();
                   
    //             } elseif ($blockchain_request->request_type == 1){
    //                 // open campaign request
    //                 $newCampaign = new Campaign();
    //                 $newCampaign->campaign_address = $newCampaignAddress;
    //                 $newCampaign->host_address = $blockchain_request->requested_user_address;
    //                 $newCampaign->minimum_contribution = $blockchain_request->amount;
    //                 $newCampaign->save();
                   
    //             } elseif ($blockchain_request->request_type == 2){
    //                 // withdraw money request
                   
    //             } 
    //             $blockchain_request->delete();
    //         } elseif ($decide_type == 'Decline'){
    //             if($blockchain_request->request_type == 0){
    //                 // valid host request
    //                 $host = User::findOrFail($blockchain_request->requested_user_address);
    //                 $host->validate_state = 0;
    //                 $host->save();
                   
    //             } elseif ($blockchain_request->request_type == 1){
    //                 // open campaign request
    //             } elseif ($blockchain_request->request_type == 2){
    //                 // withdraw money request
                   
    //             } 
    //             $blockchain_request->delete();
    //         } elseif ($decide_type == 'Cancel'){
    //             if($blockchain_request->request_type == 0){
    //                 // valid host request
    //                 $host = User::findOrFail($blockchain_request->requested_user_address);
    //                 $host->validate_state = 0;
    //                 $host->save();
                   
    //             } elseif ($blockchain_request->request_type == 1){
    //                 // open campaign request
    //             } elseif ($blockchain_request->request_type == 2){
    //                 // withdraw money request
                   
    //             } 
    //             $blockchain_request->delete();
    //         }
    //     }
    // }

    public function createValidateHostRequest(Request $request){
        $requested_to_be_host_address = $request->requested_to_be_host_address;
        $response = Http::post('http://localhost:3000/host/validate/request', [
            'requested_to_be_host_address' => $requested_to_be_host_address
        ]);
        if($response->status() == 200){
            $requestToValidateHost = new BlockchainRequest();
            $requestToValidateHost->request_id = $requested_to_be_host_address;
            $requestToValidateHost->request_type = 0;
            $requestToValidateHost->requested_user_address = $requested_to_be_host_address;
            $requestToValidateHost->save();
        } else {

        }
    }

    public function createToOpenCampaignRequest(Request $request){
        $validated_host_address = $request->validated_host_address;
        $minimum_contribution = $request->minimum_contribution;
        $response = Http::post('http://localhost:3000/host/validate/request', [
            'validated_host_address' => $validated_host_address,
            'minimum_contribution' => $minimum_contribution,
        ]);
        if($response->status() == 200){
            $requestToOpenCampaign = new BlockchainRequest();
            // $requestToOpenCampaign->request_id = ; // READ JSON
            $requestToOpenCampaign->request_type = 1;
            $requestToOpenCampaign->amount = $minimum_contribution;
            $requestToOpenCampaign->requested_user_address = $validated_host_address;
            $requestToOpenCampaign->save();
        } else {

        }
    }

    public function createWithdrawMoneyRequest(Request $request){
        $validated_host_address = $request->validated_host_address;
        $amount_of_money = $request->amount_of_money;
        $campaign_adress_target = $request->campaign_adress_target;
        $response = Http::post('http://localhost:3000/host/withdraw/campaign/request', [
            'validated_host_address' => $validated_host_address,
            'amount_of_money' => $amount_of_money,
            'campaign_adress_target' => $campaign_adress_target,
        ]);
        if($response->status() == 200){
            $requestToWithdrawMoney = new BlockchainRequest();
            // $requestToWithdrawMoney->request_id = ; // READ JSON
            $requestToWithdrawMoney->request_type = 2;
            $requestToWithdrawMoney->amount = $amount_of_money;
            $requestToWithdrawMoney->requested_user_address = $validated_host_address;
            $requestToWithdrawMoney->save();
        } else {

        }
    }
}
