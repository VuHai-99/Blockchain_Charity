<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'host_id', 'donator_number', 'coin',
        'date_started', 'date_end', 'approval_id', 'constract_address'
    ];
}