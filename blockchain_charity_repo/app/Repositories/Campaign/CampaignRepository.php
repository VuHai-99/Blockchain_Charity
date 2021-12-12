<?php

namespace App\Repositories\Campaign;

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
        $campaigns = $this->model->select('campaigns.*', 'users.name as host_name')
            ->join('users', 'users.user_address', '=', 'campaigns.host_address')
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
}