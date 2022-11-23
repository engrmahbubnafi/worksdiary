<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:55',
            'email' => 'required|string|max:100|unique:users',
            'password' => ['required', Password::default()],
            'role_id' => 'required',
            'code' => 'required|max:13|unique:users,code',
            'avatar' => 'required|image',
            'department_id' => 'required',
            'supervisor_id' => 'sometimes',
            'designation_id' => 'required',
            'status' => 'required',
            'mobile' => 'required|unique:users',
            'company_ids' => 'sometimes',
            'zone_ids' => 'sometimes',
        ];
    }
}
