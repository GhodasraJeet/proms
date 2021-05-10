<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            case "tasks.updatestage":
                return [
                    'taskid' => 'required|exists:tasks,id,status,1',
                    'old_stage_id' => 'required|exists:stage_details,id,status,1',
                    'new_stage_id' => 'required|exists:stage_details,id,status,1',
                ];
                break;
            default:
            return [];
        }
    }
}
