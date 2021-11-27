<?php

namespace App\Repositories\Campaign;

use App\Model\Campaign;
use App\Repositories\BaseRepository;
use App\Repositories\RepositoryInterface;

class CampaignRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Campaign $campaign)
    {
        parent::__construct($campaign);
    }

    public function getCampaignByUser($userAddress)
    {
        $campaigns = $this->model->select('campaigns.*', 'users.name')
            ->join('users', 'users.user_address', '=', 'campaigns.host_address')
            ->where('users.user_address', $userAddress)
            ->get();
        return $campaigns;
    }
}