<?php

namespace App\Http\Requests\Source;

use App\Models\Source;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSourceRequest extends FormRequest
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
                        Source::where($attribute, $value)
                        ->where('unit_type_id', request()->get('unit_type_id'))
                        ->exists()
                    ) {
                        $fail("This source is already there under this unit type!");
                    }
                },
            ],
            'unit_type_id' => 'required',
        ];
    }
}
