<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthorityInformation extends Authenticatable
{
    use SoftDeletes;

    protected $primaryKey = 'authority_address';
    public $incrementing = false;

    protected $fillable = [
        'authority_address', 'name', 'email', 'password', 'authority_local_name', 'authority_local_code'
    ];

    protected $hidden = [
        'password', 'remember_token', 'authority_address',
    ];
}