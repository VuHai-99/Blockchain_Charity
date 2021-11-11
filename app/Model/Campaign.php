<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'campaign_address';
    public $incrementing = false;
    protected $fillable = [
        'campaign_address','name', 'description', 'host_address', 'current_balance','minimum_contribution', 'target_contribution_amount',
        'date_started', 'date_end'
    ];
}