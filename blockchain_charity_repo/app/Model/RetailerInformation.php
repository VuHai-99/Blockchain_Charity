<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetailerInformation extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'retailer_address', 'retailer_name', 'brief_infor', 'email', 'hot_line'
    ];
}