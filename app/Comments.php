<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    use SoftDeletes;
    protected $table = "comments";

    protected $fillable = [
        'comment', 'task_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id','name','profile_picture');
    }
}
