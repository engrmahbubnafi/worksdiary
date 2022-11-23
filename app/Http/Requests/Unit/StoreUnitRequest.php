<?php

namespace App\Http\Requests\Unit;

use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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

    // public function prepareForValidation()
    // {
    //     $this->merge([
    //         'code'=>''
    //     ]);
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'unit_type_id' => 'required',
            'name' => 'required',
            'owner' => 'required',
            'as_dealer' => 'sometimes',
            'mobile' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if (
                        Unit::where($attribute, $value)
                        ->where('name', request()->get('name'))
                        ->exists()
                    ) {
                        $fail('Name already exists under this mobile.');
                    }
                },
            ],
            'district_id' => 'required',
            'upazila_id' => 'required',
            'address' => 'required',
            'status' => 'required',
            'latitude' => 'sometimes',
            'longitude' => 'sometimes',
        ];
    }
}
