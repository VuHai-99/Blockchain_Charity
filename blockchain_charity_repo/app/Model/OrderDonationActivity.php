<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDonationActivity extends Model
{
    protected $fillable = [
        'total_amount', 'receipt_url', 'retailer_address', 'order_state', 'authority_confirmation','order_code'
    ];
}