<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
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
        $status=User::find(Auth::user()->id)->update($request->all());
        if($status){
            return redirect()->route('profile.index')->withSuccess('Profile updated successfully');
        }
    }
}
