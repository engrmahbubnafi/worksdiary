<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $data = [
            'name' => 'required|string|max:55',
            'email' => 'required|string|max:100|unique:users,email,' . $this->user->id,
            'role_id' => 'required',
            'code' => 'required|unique:users,code,' . $this->user->id,
            'avatar' => 'sometimes|image',
            'department_id' => 'required',
            'supervisor_id' => 'sometimes',
            'designation_id' => 'required',
            'status' => 'required',
            'mobile' => 'required|numeric|digits:11|unique:users,mobile,' . $this->user->id,
            'company_ids' => 'sometimes',
            'zone_ids' => 'sometimes',
            'email_verified_at'=>'sometimes'
        ];

        if (!empty($this->password)) {
            $data['password'] =  Password::default();
        }

        if (!empty($this->avatar)) {
            $data['avatar'] =  'image';
        }

        return $data;
    }
}
