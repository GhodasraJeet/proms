<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            case "projects.store":
                return [
                    'project_title' => 'required|unique:projects,title',
                    'project_description' => ''
                ];
                break;
            default:
                return [];
        }
    }

    public function message()
    {
        $current_route_name = Route::currentRouteName();
        switch ($current_route_name) {
            case "projects.store":
                return [
                    'project_title.required' => 'The title field is required.',
                    'project_title.unique' => 'The title is already registered.',
                ];
                break;
            default:
                return [];
        }
    }
}
