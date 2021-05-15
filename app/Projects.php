<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{

    protected $table = "projects";

    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    // Get User involved projects
    public function projects()
    {
        return $this->hasOne(User_Project_Details::class,'project_id','id')->where('user_id',Auth::user()->id);
    }

    // Get All user involveed

    // Get all user which involved in this project
    public function users()
    {
        return $this->hasMany(User_Project_Details::class,'project_id')->with('user');
    }


}
