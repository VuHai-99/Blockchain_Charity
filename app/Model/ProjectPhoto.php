<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectPhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id', 'image', 'description'
    ];
}