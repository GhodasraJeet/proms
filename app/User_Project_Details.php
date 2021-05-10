<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Project_Details extends Model
{
    protected $table = 'user_project_details';

    protected $fillable = [
        'user_id', 'project_id', 'remover_id', 'status'
    ];

    // Project involved user details
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
