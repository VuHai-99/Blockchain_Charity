<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderReceipt extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'date_of_payment', 'total_receipt', 'host_address', 'retailer_address', 'donation_activity_address'
    ];
}