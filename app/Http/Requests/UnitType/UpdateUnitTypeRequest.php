<?php

namespace App\Http\Requests\UnitType;

use App\Models\UnitType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitTypeRequest extends FormRequest
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
            'parent_id' => 'sometimes',
            'name' => [
                'required',
                function ($attribute, $value, $fail) {

                    if (
                        UnitType::where($attribute, $value)
                        ->where('id', '<>', $this->unit_type->id)
                        ->when('parent_id', function ($query) {
                            $query->where('parent_id', request()->get('parent_id'));
                        })
                        ->exists()
                    ) {
                        $fail("This unit type is already there under this parent!");
                    }
                },
            ],
            'status' => 'required',
            'is_slot_enabled' => 'sometimes|required',
        ];
    }
}
