<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            case "users.store":
                return [
                    'user_title' => 'required|max:200',
                    'user_name' => 'required|max:200',
                    'user_email' => 'required|email|unique:user,email',
                    'user_profile' => 'mimes:png,jpg,jpeg,gif|max:2048'
                ];
                break;
            default:
            return [];
        }
    }
}
