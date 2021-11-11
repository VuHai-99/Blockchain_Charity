<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlockchainRequest extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'request_id';
    public $incrementing = false;
    protected $fillable = [
        'request_id','request_type', 'amount', 'requested_user_address'
    ];
}
