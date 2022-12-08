<?php

namespace App\Http\Requests\EmergencyVisit;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmergencyVisitRequest extends FormRequest
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
            'objectives' => 'required|array',
            'date_for' => 'required|date',
            'unit_type_id' => 'required|integer|exists:unit_types,id',
            'company_unit_id' => 'required|integer|exists:company_units,id',
            'status' => 'required',
            'task_note' => 'sometimes'
        ];

        if (!empty($this->assign_to)) {
            $data['assign_to'] =  'integer';
        }

        return $data;
    }
}
