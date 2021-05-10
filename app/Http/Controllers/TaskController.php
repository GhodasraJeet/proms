<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Tasks;

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
        $task->order=++$count;
        $task->status=1;
        if($task->save()){
            return response()->json(['success'=>true,'msg'=>'Task added successfully']);
        }
    }

    public function update_stage_task(TaskRequest $request)
    {
        $status=Tasks::where(['id'=>$request->taskid,'stage_id'=>$request->old_stage_id])->update(['stage_id'=>$request->new_stage_id]);
        if($status) {
            return response()->json(['success'=>true,'msg'=>'Task stagec changed successfully']);
        }
    }
}
