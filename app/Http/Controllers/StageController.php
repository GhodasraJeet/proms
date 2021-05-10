<?php

namespace App\Http\Controllers;

use App\Stage_Details;
use Illuminate\Http\Request;
use App\Http\Requests\StageRequest;

class StageController extends Controller
{
    public function store(StageRequest $request)
    {
        $count=Stage_Details::where(['project_id'=>$request->project_id,'status'=>1])->count();
        if(++$count>6) {
            return response()->json(['success'=>false,'msg'=>'Only create 6 board in this project']);
        }
        $count=Stage_Details::where('project_id',$request->project_id)->count();
        $stage=new Stage_Details;
        $stage->project_id=$request->project_id;
        $stage->name=$request->boardname;
        $stage->stage_order=++$count;
        $stage->status=1;
        if($stage->save()){
            return response()->json(['success'=>true,'msg'=>'Board added successfully']);
        }
    }

    public function list($projectid)
    {
        $stage_details=Stage_Details::with('tasks')->select(['id','name'])->where(['project_id'=>$projectid,'status'=>1])->orderBy('stage_order','asc')->get()->toArray();
        return response()->json(['success'=>true,'data'=>$stage_details]);
    }

    public function destroy($id)
    {
        $status=Stage_Details::find($id)->delete();
        if($status){
            return response()->json(['success'=>true,'msg'=>'Board deleted successfully']);
        }
    }
}
