<?php

namespace App\Http\Controllers;

use App\Repositories\Campaign\CampaignRepository;
use App\Repositories\DonationActivity\DonationActivityRepository;
use App\Repositories\OrderReceipt\OrderReceiptRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FrontEndController extends Controller
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
        return view('frontEnd.home');
    }

    public function campaign(Request $request)
    {
        $keyWord = $request->key_word;
        $campaigns = $this->campaignRepository->getListCampaign($keyWord);
        return view('frontEnd.campaign', compact('campaigns'));
    }

    public function detail($campaignAddress)
    {
        $campaign = $this->campaignRepository->getCampaignDetail($campaignAddress);
        $mainPic = $this->campaignRepository->getMainPicCampaign($campaignAddress);
        $sidePics = $this->campaignRepository->getSidePicCampaign($campaignAddress);
        $limit = 10;
        $userTopDonate = $this->campaignRepository->getListUserTopDonate($campaignAddress, $limit);
        $userDonateMonthLy = $this->campaignRepository->getListUserDonate($campaignAddress, $limit);
        $donationActivities = $this->campaignRepository->getListDonationActivity($campaignAddress);
        return view('frontEnd.campaign_detail', compact('campaign', 'mainPic', 'sidePics', 'userDonateMonthLy', 'userTopDonate', 'campaignAddress', 'donationActivities'));
    }

    public function donationActivityDetail($donationActivityAddress)
    {
        $donationActivity = $this->donationActivityRepository->getInforDonationActivity($donationActivityAddress);
        $listCashOut = $this->donationActivityRepository->getListCashOut($donationActivityAddress);
        $donation_activity_main_pic = $this->donationActivityRepository->getMainPicDonation($donationActivityAddress);
        $donation_activity_side_pic = $this->donationActivityRepository->getSidePicDonation($donationActivityAddress);
        $orders = $this->orderReceipt->getOrderDonationActivition($donationActivityAddress);
        return view('frontend.donation_activity_detail', compact('donationActivity', 'listCashOut', 'donation_activity_main_pic', 'donation_activity_side_pic', 'orders'));
    }
}