<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDonationActivity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'total_amount', 'receipt_url', 'rretailer_address', 'order_state', 'authority_confirmation'
    ];
}