<?php

namespace App\Repositories\OrderReceipt;

use App\Model\OrderReceipt;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

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

    public function confirmOrder($hostAddress, $date)
    {
        return $this->model->where('host_address', $hostAddress)
            ->whereNull('date_of_payment')
            ->update(['date_of_payment' => $date]);
    }

    public function getTotalOrder($hostAddress)
    {
        $receipt = $this->model->where('host_address', $hostAddress)
            ->whereNull('date_of_payment')
            ->select(DB::raw("sum(total_receipt) as total"))
            ->groupBy('host_address')
            ->first();
        return $receipt->total;
    }

    public function getHistoryPuchaseHost($hostAddress)
    {
        return $this->model->select('order_receipts.*', 'retailers.name as retailer_name', 'products.product_name')
            ->join('retailers', 'retailers.retailer_address', '=', 'order_receipts.retailer_address')
            ->join('products', 'products.id', '=', 'order_receipts.product_id')
            ->where('host_address', $hostAddress)
            ->whereNotNull('date_of_payment')
            ->orderByDesc('date_of_payment')
            ->get();
    }
}