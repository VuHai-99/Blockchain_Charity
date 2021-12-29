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

    public function getOrderByRetailer($donationActivityAddress)
    {
        return $this->model->select(
            'products.image',
            'products.product_name',
            'order_receipts.quantity',
            'products.price',
            'order_receipts.order_id',
            'order_receipts.total_receipt',
            'order_receipts.created_at',
            'products.quantity as quantity_remain',
            'order_receipts.retailer_address'
        )
            ->join('products', 'products.id', '=', 'order_receipts.product_id', '')
            ->where('order_receipts.donation_activity_address', $donationActivityAddress)
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

    public function deleteAllCart($donationActivityAddress)
    {
        return $this->model->where('donation_activity_address', $donationActivityAddress)
            ->whereNull('date_of_payment')
            ->delete();
    }

    public function confirmOrder($donationActivityAddress, $data)
    {
        return $this->model->where('donation_activity_address', $donationActivityAddress)
            ->whereNull('date_of_payment')
            ->update($data);
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

    public function getHistoryPuchase($orderId)
    {
        return $this->model->select('order_receipts.*', 'retailers.name as retailer_name', 'products.product_name', 'donation_activities.donation_activity_name')
            ->join('retailers', 'retailers.retailer_address', '=', 'order_receipts.retailer_address')
            ->join('products', 'products.id', '=', 'order_receipts.product_id')
            ->join('donation_activities', 'donation_activities.donation_activity_address', '=', 'order_receipts.donation_activity_address')
            ->where('order_receipts.order_id', $orderId)
            ->whereNotNull('date_of_payment')
            ->orderByDesc('date_of_payment')
            ->get();
    }

    public function getOrderDonationActivition($donationAddress)
    {
        return $this->model->select('*')
            ->where('donation_activity_address', $donationAddress)
            ->distinct('order_id')
            ->get();
    }

    public function getProductOrder($donationAddress)
    {
        return $this->model->select('product_id', 'quantity')
            ->where('donation_activity_address', $donationAddress)
            ->whereNull('date_of_payment')
            ->get();
    }
}