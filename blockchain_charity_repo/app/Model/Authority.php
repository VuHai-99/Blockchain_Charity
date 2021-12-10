<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Authority extends Authenticatable
{
    use Notifiable;

    protected $table = 'authorities';
    protected $primaryKey = 'authority_address';
    public $incrementing = false;

    protected $fillable = [
        'authority_address', 'name', 'email', 'password', 'authority_local_name', 'authority_local_code'
    ];

}