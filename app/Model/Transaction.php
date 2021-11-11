<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'transaction_hash';
    public $incrementing = false;
    protected $fillable = [
        'transaction_hash','sender_address', 'receiver_address', 'transaction_type', 'amount'
    ];
}
