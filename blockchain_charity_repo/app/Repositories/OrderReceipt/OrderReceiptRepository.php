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

    public function getOrderByRetailer($retailer)
    {
        return $this->model->select(
            'products.image',
            'products.product_name',
            'order_receipts.quantity',
            'products.price',
            'order_receipts.order_id',
            'order_receipts.total_receipt',
            'order_receipts.created_at'
        )
            ->join('products', 'products.id', '=', 'order_receipts.product_id', '')
            ->whereNull('date_of_payment')
            ->get();
    }

    public function delete($id)
    {
        return $this->model->where('order_id', $id)->delete();
    }

    public function updateOrder($id, $data)
    {
        return $this->model->where('order_id', $id)->update($data);
    }

    public function deleteAllCart($userAddress)
    {
        return $this->model->where('host_address', $userAddress)
            ->whereNull('date_of_payment')
            ->delete();
    }
}