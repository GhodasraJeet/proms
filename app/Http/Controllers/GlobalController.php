<?php

namespace App\Http\Controllers;

use App\User;
use App\Projects;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function routelist(Request $request)
    {
        $webroutes=['dashboard'=>route('dashboard'),'projects'=>route('projects.index'),'users'=>route('users.index')];
        $search=$request->search;
        $users=User::select('profile_picture','name','id')->where('name','like','%'.$search.'%')->get();
        $projects=Projects::select('title','id')->where('title','like','%'.$search.'%')->get();
        $result='';
        foreach($users as $item){
            $result.="<li class='list-group-item'><a href=''><img class='avatar mr-2' src='".asset('uploads/users/'.$item->id).'/'.$item->profile_picture."'><b>".$item->name."</b></a></li>";
        }
        foreach($projects as $item){
            $result.="<li class='list-group-item'><a href='".route('projects.show',$item->id)."' ><i class='fas fa-columns mr-2'></i><b data-toggle='tootltip' data-orignal-title='".$item->title."'>".$item->title."</b></a></li>";
        }
        foreach($webroutes as $key=>$item){
            if(Str::startsWith($key,$search))
            {
                $result.="<li class='list-group-item'><a href='".$item."'>".Str::ucfirst($key)."</a></li>";
            }
        }


        return response()->json(['success'=>true,'data'=>$result]);
    }
}
