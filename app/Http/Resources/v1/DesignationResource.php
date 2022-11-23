<?php

namespace App\Http\Resources\v1;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignationResource extends JsonResource
{
    public function toArray($designation)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => Str::ucfirst($this->status),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
