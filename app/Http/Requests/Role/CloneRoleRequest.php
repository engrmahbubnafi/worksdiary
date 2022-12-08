<?php

namespace App\Http\Requests\Role;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CloneRoleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {

        if ($request->isMethod('put')) {
            return [
                "name" => "required|string|max:55|unique:roles,name",
                "description" => "required|string|max:100",
                "status" => "required",
                "permission_ids" => "sometimes"
            ];
        } else {
            return [];
        }
    }
}
