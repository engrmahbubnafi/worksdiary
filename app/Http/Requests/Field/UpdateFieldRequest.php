<?php

namespace App\Http\Requests\Field;

use App\Models\Field;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFieldRequest extends FormRequest
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
                function ($attribute, $value, $fail) {
                    if (
                        Field::where($attribute, $value)
                        ->where('form_id', request()->get('form_id'))
                        ->exists()
                    ) {
                        $fail("This field is already there under this form!");
                    }
                },
            ],
            'field_group_id' => 'sometimes',
            'length' => 'required',
            'sequence' => 'sometimes',
            'reference_value' => 'sometimes',
            'compare_value' => 'sometimes',
            'field_type_id' => 'required',
            'is_required' => 'sometimes',
            'is_reportable' => 'sometimes',
            'is_formula' => 'sometimes',
            'formula' => 'sometimes',
        ];
    }
}
