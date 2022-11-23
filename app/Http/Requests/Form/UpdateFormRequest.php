<?php

namespace App\Http\Requests\Form;

use App\Models\Form;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
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
                        Form::where($attribute, $value)
                        ->where('company_id', request()->get('company_id'))
                        ->exists()
                    ) {
                        $fail("This form is already there under this company!");
                    }
                },
            ],
            'unit_type_id' => 'required',
            'number_of_fields' => 'required',
            'is_multiple' => 'required',
            'time_duration_unit' => 'required',
            'is_skippable' => 'sometimes|required',
            'status' => 'required',
        ];
    }
}
