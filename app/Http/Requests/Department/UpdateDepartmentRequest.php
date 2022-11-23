<?php

namespace App\Http\Requests\Department;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:75',
                function ($attribute, $value, $fail) {
                    if (
                        Department::where($attribute, $value)
                        ->where('company_id', request()->get('company_id'))
                        ->exists()
                    ) {
                        $fail("This department is already there under this company!");
                    }
                },
            ],
            'code' => [
                'required',
                'string',
                'max:17',
                function ($attribute, $value, $fail) {
                    if (
                        Department::where($attribute, $value)
                        ->where('company_id', request()->get('company_id'))
                        ->exists()
                    ) {
                        $fail("This code is already used for this company!");
                    }
                },
            ],
            'status' => 'required',
            'type_ids' => 'sometimes'
        ];
    }
}
