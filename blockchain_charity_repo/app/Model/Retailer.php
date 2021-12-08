<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Retailer extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $primaryKey = 'retailer_address';
    public $incrementing = false;

    protected $fillable = [
        'retailer_address', 'name', 'email', 'password', 'description', 'phone'
    ];

    protected $hidden = [
        'password', 'remember_token', 'retailer_address',
    ];
}