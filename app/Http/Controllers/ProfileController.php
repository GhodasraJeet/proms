<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('auth.profile');
    }

    public function update(AuthRequest $request)
    {
        $user=User::find(Auth::user()->id);
        $file_name='';
        if(!empty($request->profile_picture))
        {
            $destinationPath = public_path('/uploads/users/' . Auth::user()->id);
            if(!File::exists($destinationPath)) {
                @mkdir($destinationPath, 0777, true);
            }
            else
            {
                unlink($destinationPath.'/'.$user->profile_picture);
            }
            $image = request()->file('profile_picture');
            $file_name = time() . "_" . rand(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $file_name);
            $user->update($request->except(['profile_picture'])+['profile_picture'=>$file_name]);
        }
        else{
            $user->update($request->all());
        }
        return redirect()->route('profile.index')->withSuccess('Profile updated successfully');
    }
}
