<?php

namespace App\Model;

use App\User;
use App\Model\CampaignImg;
use Illuminate\Database\Eloquent\Model;


class Campaign extends Model
{

    protected $primaryKey = 'campaign_address';
    public $incrementing = false;
    protected $fillable = [
        'campaign_address', 'name', 'description', 'host_address', 'current_balance', 'minimum_contribution', 'target_contribution_amount',
        'date_started', 'date_end'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'host_address', 'user_address');
    }

    public function main_pic()
    {
        return $this->belongsTo(CampaignImg::class, 'campaign_address', 'campaign_address')->where('photo_type', 0);
    }
}