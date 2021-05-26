<?php

namespace App\Http\Controllers;

use App\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $comment=new Comments;
        $comment->comment=$request->comment;
        $comment->user_id=Auth::user()->id;
        $comment->task_id=$request->task_id;
        $comment->save();
        return response()->json(['success'=>true,'msg'=>'Comment added successfully']);
    }
}
