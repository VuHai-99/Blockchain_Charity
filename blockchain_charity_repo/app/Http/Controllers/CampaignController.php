<?php

namespace App\Http\Controllers;

use App\Model\CampaignImg;
use Illuminate\Http\Request;
use App\Services\UploadImageService;

class CampaignController extends Controller
{
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }

    public function addCampaignRequestImg(Request $request){
        $campaignImg = new CampaignImg();
        $campaignImg->file_path = $this->uploadImageService->upload($request->campaign_main_pic);
        $campaignImg->campaign_address = '0x001';
        $campaignImg->photo_type = 0;
        $campaignImg->save();
    }
}
