<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DonationActivity extends Model
{
    protected $primaryKey = 'donation_activity_address';
    public $incrementing = false;
    protected $fillable = [
        'donation_activity_address', 'campaign_address', 'host_address', 'authority_address', 'donation_activity_name', 'donation_activity_description', 'date_start', 'date_end'
    ];

    public function authority()
    {
        return $this->belongsTo(Authority::class, 'authority_address', 'authority_address');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_address', 'campaign_address');
    }
}