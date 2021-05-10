<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class StageRequest extends FormRequest
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
            case "stage.store":
                return [
                    'boardname' => 'required|unique:projects,title',
                    'project_id' => 'required|numeric|exists:projects,id,status,1'
                ];
                break;
            default:
                return [];
        }
    }
}
