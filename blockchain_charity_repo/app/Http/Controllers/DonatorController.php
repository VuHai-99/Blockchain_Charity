<?php

namespace App\Http\Controllers;

use App\Model\Campaign;
use App\Model\CampaignImg;
use App\Model\Transaction;
use App\Repositories\Campaign\CampaignRepository;
use App\Repositories\DonationActivity\DonationActivityRepository;
use App\Repositories\OrderReceipt\OrderReceiptRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DonatorController extends Controller
{

    public function __construct(
        CampaignRepository $campaignRepository,
        DonationActivityRepository $donationActivityRepository,
        OrderReceiptRepository $orderReceipt
    ) {
        $this->campaignRepository = $campaignRepository;
        $this->donationActivityRepository = $donationActivityRepository;
        $this->orderReceipt = $orderReceipt;
    }
    public function home()
    {
        return view('frontend.home');
    }

    public function listCampaign(Request $request)
    {
        $keyWord = $request->key_word;
        $campaigns = $this->campaignRepository->getListCampaign($keyWord);
        return view('donator.list_campaign', compact('campaigns'));
    }

    public function specificProject(String $blockchainAddress)
    {
        return view('donator.specific_project');
    }

    public function campaignDetail(String $campaignAddress)
    {
        $campaign = Campaign::findOrFail($campaignAddress);
        $campaign_main_pic = CampaignImg::where('campaign_address', $campaignAddress)->where('photo_type', 0)->get();
        if (count($campaign_main_pic) != 0) {
            $campaign_main_pic = $campaign_main_pic[0];
        } else {
            $campaign_main_pic = null;
        }
        $limit = 10;
        $campaign_side_pic = CampaignImg::where('campaign_address', $campaignAddress)->where('photo_type', 1)->get();
        $userTopDonate = $this->campaignRepository->getListUserTopDonate($campaignAddress, $limit);
        $userDonateMonthLy = $this->campaignRepository->getListUserDonate($campaignAddress, $limit);
        $donationActivities = $this->campaignRepository->getListDonationActivity($campaignAddress);
        return view('donator.campaign_detail', compact('campaign', 'campaignAddress', 'campaign_main_pic', 'campaign_side_pic', 'userTopDonate', 'userDonateMonthLy', 'donationActivities'));
    }

    //WS 
    public function WS_listCampaign()
    {
        $campaigns = Campaign::all();
        return view('donator.list_campaign_ws', compact('campaigns'));
    }

    public function WS_campaignDetail(String $campaignAddress)
    {
        $campaign = Campaign::findOrFail($campaignAddress);
        $campaign_main_pic = CampaignImg::where('campaign_address', $campaignAddress)->where('photo_type', 0)->get();
        if (count($campaign_main_pic) != 0) {
            $campaign_main_pic = $campaign_main_pic[0];
        } else {
            $campaign_main_pic = null;
        }
        $limit = 10;
        $campaign_side_pic = CampaignImg::where('campaign_address', $campaignAddress)->where('photo_type', 1)->get();
        $userTopDonate = $this->campaignRepository->getListUserTopDonate($campaignAddress, $limit);
        $userDonateMonthLy = $this->campaignRepository->getListUserDonate($campaignAddress, $limit);
        $donationActivities = $this->campaignRepository->getListDonationActivity($campaignAddress);
        return view('donator.campaign_detail_ws', compact('campaign',  'campaignAddress','campaign_main_pic', 'campaign_side_pic','userTopDonate', 'userDonateMonthLy', 'donationActivities'));
    }

    public function myWallet()
    {
        return view('layouts.wallet');
    }
    public function WS_donateToCampaign(Request $request)
    {
        $notification = array(
            'message' => 'Donate Successfully',
            'alert-type' => 'success'
        );
        $campaign_address = $request->campaign_address;
        $donateAPI = 'http://localhost:3000/donator/donate/campaign/';
        $donateAPI .= $campaign_address;

        $response = Http::post($donateAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'donator_address' => Auth::user()->user_address,
            'amoutOfEthereum' => $request->donation_amount,
        ]);
        if ($response->status() == 200) {
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

            $currentBalanceURL = 'http://localhost:3000/sync/balance/'.strval(Auth::user()->user_address);
            Http::get($currentBalanceURL);
            $currentCampaignURL = 'http://localhost:3000/sync/balance/campaign/'.strval($campaign_address);
            Http::get($currentCampaignURL);


            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Donate Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function donationActivityDetail($donationActivityAddress)
    {
        $donationActivity = $this->donationActivityRepository->getInforDonationActivity($donationActivityAddress);
        $listCashOut = $this->donationActivityRepository->getListCashOut($donationActivityAddress);
        $donation_activity_main_pic = $this->donationActivityRepository->getMainPicDonation($donationActivityAddress);
        $donation_activity_side_pic = $this->donationActivityRepository->getSidePicDonation($donationActivityAddress);
        $orders = $this->orderReceipt->getOrderDonationActivition($donationActivityAddress);
        return view('donator.donation_activity_detail', compact('donationActivity', 'listCashOut', 'donation_activity_main_pic', 'donation_activity_side_pic', 'orders'));
    }
}