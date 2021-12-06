<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\BlockchainRequest;
use App\Model\Campaign;
use App\Model\CampaignImg;
use App\Model\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\UploadImageService;




class BlockChainController extends Controller
{
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }

    public function storeBlockchainRequest(Request $request)
    {
        // dd($request->all());
        try {
           
            // dd($new_blockchain_request);
            if($request->cancel == true){
                $blockchain_request = BlockchainRequest::findOrFail($request->request_id);
                $blockchain_request->delete();
            } else {
                $new_blockchain_request = new BlockchainRequest();
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
            }
            
            return response()->json(['success' => 'success', 200]);
        } catch (\Exception $e) {

            return response()->json($e,400);
        }
    
    }
    public function donateToCampaign(Request $request){
        $campaign_address = $request->campaign_address;
        $donateAPI = 'http://localhost:3000/host/donate/campaign/';
        $donateAPI.=$campaign_address;

        $response = Http::post($donateAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'donator_address' => $request->user_address,
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

            return redirect()->back();
        } else {

            return redirect()->back();
        }
    }
    
    public function withdrawCampaign(Request $request){
        // $campaign_address = $request->campaign_address;
        $withdrawAPI = 'http://localhost:3000/host/withdraw/campaign/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'validated_host_address' => $request->user_address,
            'amount_of_money' => $request->withdrawal_amount, 
            "campaign_adress_target" =>  $request->campaign_address
        ]);
        if($response->status() == 200){
            $transaction_info = $response->json();
            $requestToWithdrawMoney = new BlockchainRequest();
            $requestToWithdrawMoney->request_id = $transaction_info['request_id'];
            $requestToWithdrawMoney->requested_user_address = $transaction_info['requested_user_address'];
            $requestToWithdrawMoney->amount = $transaction_info['amount'];
            $requestToWithdrawMoney->campaign_address = $request->campaign_address;
            $requestToWithdrawMoney->request_type = 2;
            $requestToWithdrawMoney->save();
            return redirect()->back();
        } else {
            return $response;
        }
        
    }

    public function hostValidateRequest(Request $request){
        // $campaign_address = $request->campaign_address;
        $withdrawAPI = 'http://localhost:3000/host/validate/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'requested_to_be_host_address' => $request->user_address,
        ]);
        if($response->status() == 200){
            $requestToWithdrawMoney = new BlockchainRequest();
            $requestToWithdrawMoney->request_id = $request->user_address;
            $requestToWithdrawMoney->requested_user_address = $request->user_address;
            $requestToWithdrawMoney->request_type = 0;
            $requestToWithdrawMoney->save();

            $user = User::findOrFail($request->user_address);
            $user->validate_state = 1;
            $user->save();
            return redirect()->back();
        } else {
            return $response;
        }
        
    }
    
    public function hostOpenCampaignRequest(Request $request){
        $withdrawAPI = 'http://localhost:3000/host/create/campaign/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'validated_host_address' => $request->user_address,
            "minimum_contribution" => $request->minimum_contribution
        ]);
        if($response->status() == 200){
            $transaction_info = $response->json();
            $requestToWithdrawMoney = new BlockchainRequest();
            $requestToWithdrawMoney->request_id = $transaction_info['request_id'];
            $requestToWithdrawMoney->requested_user_address = $request->user_address;
            $requestToWithdrawMoney->request_type = 1;
            $requestToWithdrawMoney->amount = $request->minimum_contribution;
            $requestToWithdrawMoney->campaign_name = $request->campaign_name;
            $requestToWithdrawMoney->date_start = $request->date_start;
            $requestToWithdrawMoney->date_end = $request->date_end;
            $requestToWithdrawMoney->target_contribution_amount = $request->target_contribution_amount;
            $requestToWithdrawMoney->description = $request->description;
            $requestToWithdrawMoney->save();
            return redirect()->back();
        } else {
            return $response;
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
                    $newCampaign->description = $blockchain_request->description;
                    $newCampaign->target_contribution_amount = $blockchain_request->target_contribution_amount;
                    $newCampaign->current_balance = '0';
                    $newCampaign->date_start = $blockchain_request->date_start;
                    $newCampaign->date_end = $blockchain_request->date_end;
                    $newCampaign->save();
                   
                } elseif ($blockchain_request->request_type == 2){
                    // dd($blockchain_request->campaign_address);

                    $currentCampaign = Campaign::findOrFail(strval($blockchain_request->campaign_address));
                    if($currentCampaign){
            
                        $currentCampaign->current_balance = strval(gmp_sub($currentCampaign->current_balance, $blockchain_request->amount));
                        $currentCampaign->save();
                    } else {
                        return 'Wrong Campaign';
                    }
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
            $campaign->current_balance = strval(gmp_add($campaign->current_balance, $request->amount));
            $campaign->save();

            $syncBalanceAPI = 'http://127.0.0.1:3000/sync/balance/'.$new_transaction->sender_address;

            $response = Http::get($syncBalanceAPI);
            if($response->status() == 200){
                return redirect()->back();
            } else {
                return $response;
            }
        } elseif($request->transaction_type == 1){
            $campaign = Campaign::findOrFail($request->sender_address);
            $campaign->current_balance = strval(gmp_sub($campaign->current_balance, $request->amount));
            $campaign->save();

            $syncBalanceAPI = 'http://127.0.0.1:3000/sync/balance/'.$new_transaction->receiver_address;

            $response = Http::get($syncBalanceAPI);
            if($response->status() == 200){
                return redirect()->back();
            } else {
                return $response;
            }
        }
        
    }
    
}
