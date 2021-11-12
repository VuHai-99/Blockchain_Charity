<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\BlockchainRequest;
use App\Model\Campaign;
use App\Model\Transaction;
class BlockChainController extends Controller
{
    public function storeBlockchainRequest(Request $request)
    {
        // dd($request->all());
        try {
            $new_blockchain_request = new BlockchainRequest();
            // dd($new_blockchain_request);
            $new_blockchain_request->request_id	 = $request->request_id;
            $new_blockchain_request->request_type = $request->request_type;
            $new_blockchain_request->amount = $request->amount;
            $new_blockchain_request->requested_user_address = $request->requested_user_address;

            $new_blockchain_request->campaign_address = $request->campaign_address;
            $new_blockchain_request->campaign_name = $request->campaign_name;
            $new_blockchain_request->date_start = $request->date_start;
            $new_blockchain_request->date_end = $request->date_end;
            $new_blockchain_request->target_contribution_amount = $request->target_contribution_amount;
            $new_blockchain_request->description = $request->description;
            $new_blockchain_request->save();

            if($new_blockchain_request->request_type == 0){
                // valid host request
                $host = User::findOrFail($new_blockchain_request->requested_user_address);
                $host->validate_state = 1;
                $host->save();
            }
            return response()->json(['success' => 'success', 200]);
        } catch (\Exception $e) {

            return response()->json($e,400);
        }
    
    }

    public function decideBlockchainRequest(Request $request)
    {
        // 0 is valid host, 1 is open campaign, 2 is withdraw money
        $request_id = strval($request->request_id);
        $decide_type= $request->decide_type;
        $newCampaignAddress = "";
        if($request->newCampaignAddress){
            $newCampaignAddress = $request->newCampaignAddress;
        }
        // dd($request->all());
        // return response()->json($request->all(),400);
        $blockchain_request = BlockchainRequest::find($request_id);
        // return response()->json($blockchain_request,400);
        if($blockchain_request){
            if($decide_type == 'Accept'){
                if($blockchain_request->request_type == 0){
                    // valid host request
                    $host = User::findOrFail($blockchain_request->requested_user_address);
                    $host->validate_state = 2;
                    $host->save();
                   
                } elseif ($blockchain_request->request_type == 1){
                    // open campaign request
                    $newCampaign = new Campaign();
                    $newCampaign->campaign_address = $newCampaignAddress;
                    $newCampaign->host_address = $blockchain_request->requested_user_address;
                    $newCampaign->minimum_contribution = $blockchain_request->amount;

                    $newCampaign->name = $blockchain_request->campaign_name;
                    $newCampaign->target_contribution_amount = $blockchain_request->target_contribution_amount;
                    $newCampaign->current_balance = '0';
                    $newCampaign->date_start = $blockchain_request->date_start;
                    $newCampaign->date_end = $blockchain_request->date_end;
                    $newCampaign->save();
                   
                } elseif ($blockchain_request->request_type == 2){
                    // withdraw money request
                   
                } 
                $blockchain_request->delete();
            } elseif (($decide_type == 'Decline') || ($decide_type == 'Cancel')){
                if($blockchain_request->request_type == 0){
                    // valid host request
                    $host = User::findOrFail($blockchain_request->requested_user_address);
                    $host->validate_state = 0;
                    $host->save();
                   
                } elseif ($blockchain_request->request_type == 1){
                    // open campaign request
                } elseif ($blockchain_request->request_type == 2){
                    // withdraw money request
                   
                } 
                $blockchain_request->delete();
            }
        }
    }

    public function storeTransaction(Request $request)
    {
        $new_transaction = new Transaction();
        $new_transaction->transaction_hash = $request->transaction_hash;
        $new_transaction->sender_address = $request->sender_address;
        $new_transaction->receiver_address =$request->receiver_address;
        $new_transaction->transaction_type = $request->transaction_type;
        $new_transaction->amount = $request->amount;
        $new_transaction->save();

        if($request->transaction_type == 0){
            $campaign = Campaign::findOrFail($request->receiver_address);
            
        } elseif($request->transaction_type == 1) {

        }
    }
    
}
