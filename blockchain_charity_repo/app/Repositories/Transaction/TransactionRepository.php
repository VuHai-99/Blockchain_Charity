<?php

namespace App\Repositories\Transaction;

use App\Model\Transaction;
use App\Repositories\BaseRepository;
use App\Repositories\RepositoryInterface;

class TransactionRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }

    public function getListUserTopDonate()
    {
        $users = $this->model->select();
    }
}