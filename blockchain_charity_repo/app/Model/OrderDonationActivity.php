<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDonationActivity extends Model
{
    protected $fillable = [
        'total_amount', 'receipt_url', 'retailer_address', 'order_state', 'authority_confirmation','order_code','donation_activity_address'
    ];

    public function donation_activity()
    {
        return $this->belongsTo(DonationActivity::class, 'donation_activity_address', 'donation_activity_address');
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class, 'retailer_address', 'retailer_address');
    }
}