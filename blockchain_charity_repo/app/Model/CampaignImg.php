<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CampaignImg extends Model
{
    protected $fillable = [
        'campaign_address','photo_type','file_path','donation_activity_address'
    ];
}
