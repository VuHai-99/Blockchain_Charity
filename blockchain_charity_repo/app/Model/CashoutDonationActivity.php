<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CashoutDonationActivity extends Model
{
    protected $fillable = [
        'cashout_amount', 'authority_confirmation','cashout_code'
    ];
}
