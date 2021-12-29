<?php

namespace App\Repositories\DonationActivity;

use App\Enums\EnumCampaign;
use App\Model\DonationActivity;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class DonationActivityRepository extends BaseRepository
{
    public function __construct(DonationActivity $donationActivity)
    {
        parent::__construct($donationActivity);
    }

    public function getListCashOut($donationActivityAddress)
    {
        return DB::table('cashout_donation_activities')
            ->select('cashout_donation_activities.*')
            ->where('donation_activity_address', $donationActivityAddress)
            ->get();
    }

    public function getInforDonationActivity($donationActivityAddress)
    {
        return $this->model->select(
            'donation_activities.*',
            'campaigns.name as campaign_name'
        )
            ->join('campaigns', 'campaigns.campaign_address', '=', 'donation_activities.campaign_address')
            ->where('donation_activities.donation_activity_address', $donationActivityAddress)
            ->first();
    }

    public function getMainPicDonation($donationActivityAddress)
    {
        return DB::table('campaign_imgs')
            ->select('campaign_imgs.file_path')
            ->where('campaign_imgs.donation_activity_address', $donationActivityAddress)
            ->where('campaign_imgs.photo_type', EnumCampaign::IMAGE_MAIN_DONATION_ACTIVITY)
            ->first();
    }

    public function getSidePicDonation($campaignAddress)
    {
        return DB::table('campaign_imgs')->select('campaign_imgs.file_path')
            ->where('campaign_imgs.donation_activity_address', $campaignAddress)
            ->where('campaign_imgs.photo_type', EnumCampaign::IMAGE_SIDE_DONATION_ACTIVITY)
            ->get();
    }
}