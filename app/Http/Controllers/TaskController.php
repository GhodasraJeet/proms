<?php

namespace App\Http\Controllers;

use App\Tasks;
use App\Comments;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function store(TaskRequest $request)
    {
        $count=Tasks::where('project_id',$request->project_id)->count();
        $task = new Tasks;
        $task->title=$request->tasktitle;
        $task->description=$request->taskdescription;
        $task->project_id=$request->project_id;
        $task->stage_id=$request->stage_id;
        $task->user_id=$request->taskusers;
        $task->order=++$count;
        $task->status=1;
        if($task->save()){
            Mail::to(Auth::user()->email)->send(new WelcomeEmail(Auth::user()));

            return response()->json(['success'=>true,'msg'=>'Task added successfully']);
        }
    }

    public function update_stage_task(TaskRequest $request)
    {
        $status=Tasks::where(['id'=>$request->taskid,'stage_id'=>$request->old_stage_id])->update(['stage_id'=>$request->new_stage_id]);
        if($status) {
            return response()->json(['success'=>true,'msg'=>'Task stage changed successfully']);
        }
    }

    public function show($id)
    {
        $task=Tasks::findOrFail($id);
        $comments=Comments::where(['task_id'=>$id])->with('user')->get();
        $result='';
        $status='';
        if($task->status==2)
        {
            $status="checked";
        }
        $result.="<div class='row'><div class='col-md-2'><div class='checkbox'>
        <label style='font-size: 2.5em'><input type='checkbox' id='taskstatus' ".$status."><span class='cr'><i class='cr-icon fa fa-check'></i></span>
        </label></div></div><div class='col-md-8'>";
        $result.="<h3>".$task->title."</h3><p>".$task->description."</p>";
        $result.="</div></div>";
        $result.="<div class='row'><div class='col-md-12'><form id='comment-add-form' action=".route('comments.store')." method='post'><div class='form-group'><textarea name='user_text_comment' class='form-control' id='user_text_comment'></textarea><button type='submit' class='btn btn-primary'>Add Comment</button></form></div></div></div>";
        $result.="<ul>";
        foreach($comments as $comment){
            $result.="<li>".$comment->comment.$comment->name."</li>";
        }
        $result.="</ul>";

        if($task) {
            return response()->json($result);
        }
    }

    public function update_task_status(Request $request)
    {
        $check='';
        $msg='';
        $task_details=Tasks::where(['id'=>$request->task_id])->firstOrFail();
        if($task_details->status==1){
            $task_details->status=2;
            $check=true;
            $msg='Task completed';
        }
        else if($task_details->status==2){
            $task_details->status=1;
            $check=false;
        }
        $task_details->save();
        Mail::to(Auth::user()->email)->send(new WelcomeEmail(Auth::user()));
        return response()->json(['success'=>true,'msg'=>$msg,'check'=>$check]);
    }
}
