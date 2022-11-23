<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitTypeResource extends JsonResource
{
    public function toArray($unit_types)
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'slotable' => $this->slotable
        ];
    }
}
