<?php

namespace App\Http\Resources\v1;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($role)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => Str::ucfirst($this->status),
            'is_editable' => $this->is_editable,
            'is_deletable' => $this->is_deletable,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
