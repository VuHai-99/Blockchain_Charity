<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'host_address', 'current_balance','minimum_contribution',
        'date_started', 'date_end','contract_address'
    ];
}