<?php

namespace App\Repositories\OrderReceipt;

use App\Model\OrderReceipt;
use App\Repositories\BaseRepository;

class OrderReceiptRepository extends BaseRepository
{
    public function __construct(OrderReceipt $orderReceipt)
    {
        parent::__construct($orderReceipt);
    }
}