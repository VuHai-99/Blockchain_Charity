<?php

namespace App\Http\Controllers;

use App\Model\BlockchainRequest;
use App\Model\Campaign;
use App\Model\CampaignImg;
use App\Model\Transaction;
use App\Repositories\BlockChain\BlockChainRequestRepository;
use App\Repositories\Campaign\CampaignRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\UploadImageService;

class HostController extends Controller
{
    public function __construct(
        BlockChainRequestRepository $blockChainRequest,
        CampaignRepository $campaignRepository,
        UploadImageService $uploadImageService
    ) {
        $this->blockChainRequest = $blockChainRequest;
        $this->campaignRepository = $campaignRepository;
        $this->uploadImageService = $uploadImageService;
    }

    public function home()
    {
        return view('frontend.home');
    }

    public function listCampaign()
    {
        // $campaigns = $this->campaignRepository->getListCampaign();
        $campaigns = Campaign::all();
        return view('host.list_campaign', compact('campaigns'));
    }

    public function createCampaign()
    {
        return view('host.create_campaign');
    }

    public function editCampaignDetail($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $campaign_main_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',0)->get();
        if(count($campaign_main_pic) != 0){
            $campaign_main_pic=$campaign_main_pic[0];
        } else {
            $campaign_main_pic = null;
        }
        // $campaign_main_pic=$campaign_main_pic[0];
        $campaign_side_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',1)->get();
        return view('host.edit_campaign_detail', compact('campaign','campaign_main_pic','campaign_side_pic'));
    }
    
    public function listRequest()
    {
        // $userAddress = Auth::user()->user_address;
        // $listRequest = $this->blockChainRequest->getListRequestByUser($userAddress);    
        // dd(Auth::user()->user_address);
        $listRequest = BlockchainRequest::where('requested_user_address',Auth::user()->user_address)->get();
        return view('host.list_request', compact('listRequest'));
    }


    public function deleteRequest($requestId)
    {
        $notification = array(
            'message' => 'Hủy request thành công',
            'alert-type' => 'success'
        );
        $this->blockChainRequest->deleteRequest($requestId);
        return back()->with($notification);
    }

    public function validateHost()
    {
        return view('host.validate_host');
    }

    public function campaignDetail($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $userTopDonate = $this->campaignRepository->getListUserTopDonate($blockchainAddress);
        $limit =  10;
        $userUserDonateMonthLy = $this->campaignRepository->getListUserDonate($blockchainAddress, $limit);
        $campaign_main_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',0)->get();
        
        if(count($campaign_main_pic) != 0){
            $campaign_main_pic=$campaign_main_pic[0];
        } else {
            $campaign_main_pic = null;
        }
        // dd($campaign_main_pic);
        $campaign_side_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',1)->get();
        
        return view('host.campaign_detail', compact('campaign', 'userUserDonateMonthLy', 'userTopDonate','campaign_main_pic','campaign_side_pic'));
    }

    public function updateCampaign($blockchainAddress,Request $request){
        $notification = array(
            'message' => 'Update campaign thành công',
            'alert-type' => 'success'
        );
        $new_campaign = Campaign::findOrFail($blockchainAddress);
        $new_campaign->name = $request->campaign_name;
        $new_campaign->campaign_address = $blockchainAddress;
        $new_campaign->description = $request->description;
        $new_campaign->target_contribution_amount = $request->target_contribution_amount;
        $new_campaign->date_start = $request->date_start;
        $new_campaign->date_end = $request->date_end;
        $new_campaign->save();

        // $campaign_main_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',0)->get();
        // unlink($campaign_main_pic[0]->file_path);
        if ($request->hasFile('image')) {
            $file = $request->image;
            $data['image'] = $this->uploadService->upload($file);
        }

        if($request->campaign_main_pic){
            $campaignImg = new CampaignImg();
            $campaignImg->file_path = $this->uploadImageService->upload($request->campaign_main_pic);
            $campaignImg->campaign_address = $blockchainAddress;
            $campaignImg->photo_type = 0;
            $campaignImg->save();

            
        }
       
        if($request->campaign_multi_img){
            foreach($request->campaign_multi_img as $multi_img){
                $campaignImg = new CampaignImg();
                $campaignImg->file_path = $this->uploadImageService->upload($multi_img);
                $campaignImg->campaign_address = $blockchainAddress;
                $campaignImg->photo_type = 1;
                $campaignImg->save();
            }
        }
        
        return back()->with($notification);
    }

    //WS

    public function WS_listRequest()
    {
        // $userAddress = Auth::user()->user_address;
        // $listRequest = $this->blockChainRequest->getListRequestByUser($userAddress);
        $listRequest = BlockchainRequest::where('requested_user_address',Auth::user()->user_address)->get();
        return view('host.list_request_ws', compact('listRequest'));
    }
    public function WS_listCampaign()
    {
        // $campaigns = $this->campaignRepository->getListCampaign();
        $campaigns = Campaign::all();
        return view('host.list_campaign_ws', compact('campaigns'));
    }

    public function WS_campaignDetail($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $userTopDonate = $this->campaignRepository->getListUserTopDonate($blockchainAddress);
        $limit =  10;
        $userUserDonateMonthLy = $this->campaignRepository->getListUserDonate($blockchainAddress, $limit);
        $campaign_main_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',0)->get();
        if(count($campaign_main_pic) != 0){
            $campaign_main_pic=$campaign_main_pic[0];
        } else {
            $campaign_main_pic = null;
        }
        $campaign_side_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',1)->get();
        return view('host.campaign_detail_ws', compact('campaign', 'userUserDonateMonthLy', 'userTopDonate','campaign_main_pic','campaign_side_pic'));
    }

    public function WS_validateHost()
    {
        $host = Auth::user();
        return view('host.validate_host_ws', compact('host'));
    }

    public function WS_createCampaign()
    {
        return view('host.create_campaign_ws');
    }

    public function WS_donateToCampaign(Request $request)
    {

        $campaign_address = $request->campaign_address;
        $donateAPI = 'http://localhost:3000/donator/donate/campaign/';
        $donateAPI .= $campaign_address;

        $response = Http::post($donateAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'donator_address' => Auth::user()->user_address,
            'amoutOfEthereum' => $request->donation_amount,
        ]);
        if ($response->status() == 200) {
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

    public function WS_withdrawCampaign(Request $request)
    {
        $withdrawAPI = 'http://localhost:3000/host/withdraw/campaign/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'validated_host_address' => Auth::user()->user_address,
            'amount_of_money' => $request->withdrawal_amount,
            "campaign_adress_target" =>  $request->campaign_address
        ]);
        if ($response->status() == 200) {
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

    public function WS_hostValidateRequest(Request $request)
    {
        $withdrawAPI = 'http://localhost:3000/host/validate/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'requested_to_be_host_address' => Auth::user()->user_address,
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to Validate Account Successfully',
                'alert-type' => 'success'
            );
            $requestToWithdrawMoney = new BlockchainRequest();
            $requestToWithdrawMoney->request_id = $request->user_address;
            $requestToWithdrawMoney->requested_user_address = $request->user_address;
            $requestToWithdrawMoney->request_type = 0;
            $requestToWithdrawMoney->save();

            $user = User::findOrFail($request->user_address);
            $user->validate_state = 1;
            $user->save();
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to Validate Account Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_hostOpenCampaignRequest(Request $request)
    {
        $withdrawAPI = 'http://localhost:3000/host/create/campaign/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'validated_host_address' => Auth::user()->user_address,
            "minimum_contribution" => $request->minimum_contribution
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to open campaign Successfully',
                'alert-type' => 'success'
            );

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

            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to open campaign Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_editCampaignDetail($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $campaign_main_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',0)->get();
        if(count($campaign_main_pic)){
            $campaign_main_pic=$campaign_main_pic[0];
        }
        $campaign_side_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',1)->get();
        return view('host.edit_campaign_detail_ws', compact('campaign','campaign_main_pic','campaign_side_pic'));
    }

    public function WS_updateCampaign ($blockchainAddress,Request $request){
        $notification = array(
            'message' => 'Update campaign thành công',
            'alert-type' => 'success'
        );
        $new_campaign = Campaign::findOrFail($blockchainAddress);
        $new_campaign->name = $request->campaign_name;
        $new_campaign->campaign_address = $blockchainAddress;
        $new_campaign->description = $request->description;
        $new_campaign->target_contribution_amount = $request->target_contribution_amount;
        $new_campaign->date_start = $request->date_start;
        $new_campaign->date_end = $request->date_end;
        $new_campaign->save();

        // $campaign_main_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',0)->get();
        // unlink($campaign_main_pic[0]->file_path);
        if($request->campaign_main_pic){
            $campaignImg = new CampaignImg();
            $campaignImg->file_path = $this->uploadImageService->upload($request->campaign_main_pic);
            $campaignImg->campaign_address = $blockchainAddress;
            $campaignImg->photo_type = 0;
            $campaignImg->save();
        }
    
        if($request->campaign_multi_img){
            foreach($request->campaign_multi_img as $multi_img){
                $campaignImg = new CampaignImg();
                $campaignImg->file_path = $this->uploadImageService->upload($multi_img);
                $campaignImg->campaign_address = $blockchainAddress;
                $campaignImg->photo_type = 1;
                $campaignImg->save();
            }    
        }
        
        return back()->with($notification);
    }

    public function WS_cancelRequestOpenCampaign($request_id,Request $request){
        $withdrawAPI = 'http://127.0.0.1:3000/host/cancel/openCampaign/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'host_address' => Auth::user()->user_address,
            "request_id" => $request_id
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to cancel open campaign Successfully',
                'alert-type' => 'success'
            );

            $requestcancel = BlockchainRequest::where('request_id',$request_id);
            $requestcancel->delete();

            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to open campaign Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}