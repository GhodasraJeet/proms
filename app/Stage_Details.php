<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage_Details extends Model
{
    use SoftDeletes;
    protected $table = "stage_details";
    protected $fillable = [
        'name', 'project_id', 'status'
    ];
    protected $hidden = [
        'deleted_at'
    ];

    // Get Tasks
    public function tasks()
    {
        return $this->hasMany(Tasks::class,'stage_id','id');
    }
}
