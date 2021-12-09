<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name', 'slug', 'image', 'retailer_address', 'quantity', 'price', 'category_id', 'display'
    ];
}