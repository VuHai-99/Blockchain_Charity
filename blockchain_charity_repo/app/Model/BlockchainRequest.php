<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class BlockchainRequest extends Model
{
    protected $primaryKey = 'request_id';
    public $incrementing = false;
    protected $fillable = [
        'request_id','request_type', 'amount', 'requested_user_address','authority_address','donation_activity_address','campaign_address','campaign_name','date_start','date_end','target_contribution_amount','description'
    ];

    public function campaign(){
        return $this->belongsTo(Campaign::class,'campaign_address','campaign_address');
    }
    public function authority(){
        return $this->belongsTo(Authority::class,'authority_address','authority_address');
    }
    public function donation_activity(){
        return $this->belongsTo(DonationActivity::class,'donation_activity_address','donation_activity_address');
    }
}
