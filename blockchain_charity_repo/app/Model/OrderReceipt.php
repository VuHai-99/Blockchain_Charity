<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderReceipt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ordere_id', 'product_id', 'quantity', 'date_of_payment'
    ];
}