<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DonationActivity extends Model
{
    protected $primaryKey = 'donation_activity_address';
    public $incrementing = false;
    protected $fillable = [
        'donation_activity_address', 'campaign_address', 'host_address', 'authority_address','donation_activity_name','donation_activity_description'
    ];
}