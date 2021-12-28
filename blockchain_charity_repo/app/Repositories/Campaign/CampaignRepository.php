<?php

namespace App\Repositories\Campaign;

use App\Enums\EnumCampaign;
use App\Model\Campaign;
use App\Repositories\BaseRepository;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\DB;

class CampaignRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Campaign $campaign)
    {
        parent::__construct($campaign);
    }

    public function getListCampaign($keyWord)
    {
        $campaigns = $this->model->select('campaigns.*', 'users.name as host_name', 'users.wallet_type', 'campaign_imgs.file_path')
            ->join('users', 'users.user_address', '=', 'campaigns.host_address')
            ->join('campaign_imgs', 'campaign_imgs.campaign_address', '=', 'campaigns.campaign_address')
            ->where('campaign_imgs.photo_type', EnumCampaign::IMAGE_MAIN)
            ->when($keyWord, function ($query) use ($keyWord) {
                return $query->where('campaigns.name', 'like', '%' . $keyWord . '%');
            })
            ->get();
        return $campaigns;
    }

    public function getListUserTopDonate($campaignAddress, $limit)
    {
        $transactions = $this->model->select(
            'transactions.sender_address',
            DB::raw('sum(transactions.amount) as total_donate'),
        )
            ->join('transactions', 'transactions.receiver_address', '=', 'campaigns.campaign_address')
            ->where('campaigns.campaign_address', $campaignAddress)
            ->groupBy('transactions.sender_address')
            ->orderByDesc('total_donate');
        $users = DB::table('users')
            ->select('users.name', 'transaction.total_donate', 'users.user_address', 'users.home_address')
            ->joinSub($transactions, 'transaction', function ($join) {
                $join->on('transaction.sender_address', '=', 'users.user_address');
            })
            ->skip(0)
            ->take($limit)
            ->get();
        return $users;
    }

    public function getListUserDonate($campaignAddress, $limit)
    {
        $users =  $this->model->select(
            'users.name',
            'users.user_address',
            'users.home_address',
            'transactions.amount',
            DB::raw("DATE_FORMAT(transactions.created_at, '%d/%m/%Y') as donated_at")
        )
            ->join('transactions', 'transactions.receiver_address', '=', 'campaigns.campaign_address')
            ->join('users', 'users.user_address', '=', 'transactions.sender_address')
            ->where('campaigns.campaign_address', $campaignAddress)
            ->orderByDesc('transactions.created_at');
        if ($limit) {
            $users = $users->skip(0)->take($limit);
        }
        return $users->get();
    }

    public function getCampaignDetail($campaignAddress)
    {
        return $this->model->select(
            'campaigns.*',
            'users.name as host_name',
            'users.user_address',
            'users.email as host_email',
            'users.phone as host_phone'
        )
            ->join('users', 'users.user_address', '=', 'campaigns.host_address')
            ->where('campaigns.campaign_address', $campaignAddress)
            ->first();
    }

    public function getMainPicCampaign($campaignAddress)
    {
        return $this->model->select('campaign_imgs.file_path')
            ->join('campaign_imgs', 'campaign_imgs.campaign_address', '=', 'campaigns.campaign_address')
            ->where('campaigns.campaign_address', $campaignAddress)
            ->where('campaign_imgs.photo_type', EnumCampaign::IMAGE_MAIN)
            ->first();
    }

    public function getSidePicCampaign($campaignAddress)
    {
        return $this->model->select('campaign_imgs.file_path')
            ->join('campaign_imgs', 'campaign_imgs.campaign_address', '=', 'campaigns.campaign_address')
            ->where('campaigns.campaign_address', $campaignAddress)
            ->where('campaign_imgs.photo_type', '!=', EnumCampaign::IMAGE_MAIN)
            ->get();
    }

    public function getCampaignByDonationActivity($donationActivityAddress)
    {
        return $this->model->select('campaigns.*')
            ->join('donation_activities', 'donation_activities.campaign_address', '=', 'campaigns.campaign_address')
            ->where('donation_activities.donation_activity_address', $donationActivityAddress)
            ->first();
    }
}