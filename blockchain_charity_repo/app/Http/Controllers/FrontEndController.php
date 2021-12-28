<?php

namespace App\Http\Controllers;

use App\Repositories\Campaign\CampaignRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FrontEndController extends Controller
{
    public function __construct(CampaignRepository $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
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
        return view('frontEnd.campaign_detail', compact('campaign', 'mainPic', 'sidePics', 'userDonateMonthLy', 'userTopDonate', 'campaignAddress'));
    }
}
