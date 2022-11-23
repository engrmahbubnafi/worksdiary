<?php

namespace App\Http\Requests\Zone;

use App\Models\Zone;
use Illuminate\Foundation\Http\FormRequest;

class UpdateZoneRequest extends FormRequest
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
                        Zone::where($attribute, $value)
                        ->where('company_id', $this->company->id)
                        ->where('id', '<>', $this->zone->id)
                        ->exists()
                    ) {
                        $fail(":attribute already exists.");
                    }
                },
            ],
            'status' => 'required',
        ];
    }
}
