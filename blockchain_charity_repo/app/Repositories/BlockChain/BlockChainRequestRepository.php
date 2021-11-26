<?php

namespace App\Repositories\BlockChain;

use App\Model\BlockchainRequest;
use App\Repositories\BaseRepository;
use App\Repositories\RepositoryInterface;

class BlockChainRequestRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(BlockchainRequest $blockchain)
    {
        parent::__construct($blockchain);
    }

    public function getListRequestByUser($userAddress)
    {
        return $this->model->where('requested_user_address', $userAddress)
            ->select(
                'request_id',
                'amount',
                'campaign_address',
                'campaign_name',
                'date_start',
                'date_end',
                'target_contribution_amount',
                'description'
            )
            ->get();
    }

    public function deleteRequest($requestId)
    {
        return $this->model->where('request_id', $requestId)->delete();
    }
}