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
        $campaign = $this->campaignRepository->getListCampaign($keyWord);
        return view('frontEnd.campaign', compact($campaign));
    }

    public function detail($id)
    {
        return view('frontEnd.campaign_detail');
    }
}
