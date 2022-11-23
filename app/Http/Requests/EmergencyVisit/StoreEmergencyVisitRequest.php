<?php

namespace App\Http\Requests\EmergencyVisit;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmergencyVisitRequest extends FormRequest
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
            'name' => 'required',
            'date_for' => 'required|date',
            'company_unit_id' => 'required|integer',
            'assign_to' => 'required|integer',
            'unit_type_id' => 'required|integer',
            'zone_id' => 'sometimes|integer',
            'visit_note' => 'sometimes'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The task objective field is required',
        ];
    }
}
