<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonationActivity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'donation_activity_address', 'campaign_address', 'host_address', 'authority_address'
    ];
}