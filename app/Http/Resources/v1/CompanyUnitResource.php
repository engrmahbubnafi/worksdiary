<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company_unit_id' => $this->company_unit_id,
            'name' => $this->name,
            'code' => $this->code,
            'mobile' => $this->mobile,
            'owner' => $this->owner,
            'as_dealer' => $this->as_dealer,
            'unit_type_id' => $this->unit_type_id,
            'unit_type' => $this->unit_type_name,
            'company' => $this->company_name
        ];
    }
}
