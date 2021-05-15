<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Projects;
use Illuminate\Http\Request;
use App\User_Project_Details;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            $project_lists=Projects::with(['projects','users']);

            if(!empty($request->search)){
                $search = $request->search;
                $project_lists->where(function($query) use($search){
                  $query->where('title','like','%'.$search.'%')->orWhere('description','like','%'.$search.'%');
                });
            }
            $projects=$project_lists->paginate(10);
            return view('projects.pagination',compact('projects'))->render();
        }
        else
        {
            $projects=Projects::with(['projects','users'])->paginate(10);
            return view('projects.index',compact('projects'));
        }
    }

    public function store(ProjectRequest $request)
    {
        try
        {
            $project=new Projects;
            $project->title = $request->project_title;
            $project->description = $request->project_description;
            $project->user_id = Auth::user()->id;
            $project->status = 1;
            $project->save();

            $user=new User_Project_Details;
            $user->user_id = Auth::user()->id;
            $user->project_id = $project->id;
            $user->status = 1;
            if($user->save()){

                return response()->json(['success'=>true,'msg'=>'Project added successfully']);
            }
        }
        catch(Exception $ex)
        {
            dd($ex->getMessage());
        }
    }

    public function show($id=null)
    {
        try
        {
            $project=Projects::with('users')->findOrFail($id);
            // dd($project);
            return view('projects.show',compact('project'));
        }
        catch(Exception $ex)
        {
            dd($ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        // try
        // {
            $project=Projects::findOrFail($request->id);
            if($request->column=="title")
            {
                $project->title=$request->title;
            }
            if($request->column=="description")
            {
                $project->description=$request->title;
            }
            $project->save();
            return response()->json(['success'=>true,'msg'=>'Project Title updated successfully']);
        // }
        // catch(Exception $ex){

        // }
    }

    public function involeduser(Request $request)
    {
        // dd($request->all());
        // try
        // {
            $project_id=$request->project_id;
            $involedusers=User::with('projects')->whereHas('projects',function($query) use($project_id){
                $query->where('project_id',$project_id);
            })->pluck('id')->toArray();
// dd($users);
            // dd(in_array(2,$users));
            $users=User::get();
            $response="<form action='".route('user.updateuserproject')."' method='post'>";
            foreach($users as $user)
            {
                // dd($users);
                                // dd($status);
                $response.="<div class='custom-control custom-checkbox'>";
                if(in_array($user->id,$involedusers))
                {
                    $response.="
                    <input type='checkbox' class='custom-control-input exists' data-status='exists' value='$user->id'  id='user-manage-$user->id' checked >";

                }
                else
                {
                    $response.="
                    <input type='checkbox' class='custom-control-input noexists' value='$user->id' id='user-manage-$user->id' >";
                }

             $response.="
                <label class='custom-control-label' for=user-manage-".$user->id.">
                  <span class='d-flex align-items-center'>
                  <img alt='$user->name' src='".asset('uploads/users/'.$user->id.'/'.$user->profile_picture)."' class='avatar mr-2'>
                    <span class='h6 mb-0 SPAN-filter-by-text' data-filter-by='text'>".$user->name."</span>
                  </span>
                </label>
              </div>";
            }
            $response.="</form>";
            return response()->json(['success'=>true,'data'=>$response,'msg'=>'Project Title updated successfully']);
        // }
        // catch(Exception $ex)
        // {

        // }
    }

    public function updateuserproject(Request $request)
    {
        if($request->status=="remove"){
            $status=User_Project_Details::where(['user_id'=>$request->id,'project_id'=>$request->project_id])->delete();
            return response()->json(['success'=>true,'data'=>$status,'msg'=>'user removed successfully']);
        }
        else if($request->status=="add"){
            $user=new User_Project_Details;
            $user->user_id=$request->id;
            $user->project_id=$request->project_id;
            $user->status=1;
            $user->save();
            return response()->json(['success'=>true,'data'=>$user,'msg'=>'User added for this project successfully']);
        }
    }
}
