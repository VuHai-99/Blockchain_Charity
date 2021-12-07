<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthorityInformation extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'authority_address', 'email', 'password', 'authority_location_name', 'authority_location_post_code'
    ];

    
}