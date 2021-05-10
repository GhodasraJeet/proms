<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $current_route_name = Route::currentRouteName();
        switch ($current_route_name) {
            case "profile.update":
                return [
                    'name'=>'min:2|max:200',
                    'email'=>'unique:users,email,'.Auth::user()->id,
                    'title'=>'min:2|max:200'
                ];
                break;
            default:
                return [];
        }
    }
}
