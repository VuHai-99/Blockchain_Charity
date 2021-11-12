<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    protected $primaryKey = 'transaction_hash';
    public $incrementing = false;
    protected $fillable = [
        'transaction_hash','sender_address', 'receiver_address', 'transaction_type', 'amount'
    ];
}
