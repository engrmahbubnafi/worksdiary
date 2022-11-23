<?php

namespace App\Http\Requests\SourceDetail;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSourceDetailRequest extends FormRequest
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
            'from' => 'nullable',
            'to' => 'nullable',
            'value' => 'required',
            'is_default' => 'required',
            'status' => 'required',
        ];
    }
}
