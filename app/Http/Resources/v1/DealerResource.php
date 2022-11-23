<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class DealerResource extends JsonResource
{
    public function toArray($dealer)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'district_id' => $this->district_id,
            'thana_id' => $this->thana_id,
            'address' => $this->address,
            'status' => Str::ucfirst($this->status),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
