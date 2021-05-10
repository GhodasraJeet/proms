<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'title', 'description', 'project_id', 'order', 'stage_id'
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
