<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->as_dealer == 0) {
            $dealer = "No";
        } else {
            $dealer = "Yes";
        }

        if ($this->address && $this->district_name && $this->upazila_name) {
            $address = $this->address . ", " . $this->upazila_name . ", " . $this->district_name;
        } else {
            $address = "";
        }

        if ($this->latitude && $this->longitude) {
            $location = $this->latitude . ", " . $this->longitude;
        } else {
            $location = "";
        }

        if ($this->status == 'active') {
            $status = "Active";
        } else {
            $status = "Inactive";
        }

        return [
            'unit_type' => $this->unit_type_name,
            'unit' => $this->name,
            'code' => $this->code,
            'owner' => $this->owner,
            'dealer' => $dealer,
            'mobile' => $this->mobile,
            'address' => $address,
            'location' => $location,
            'status' => $status,
        ];
    }
}
