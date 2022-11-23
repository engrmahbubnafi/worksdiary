<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
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
            'name' => $this->name,
            'status' => $this->status,
            'unit_type' => $this->unit_type,
            'unit_id' => $this->unit_id,
            'unit_name' => $this->unit_name,
            'company_name' => $this->company_name,
            'created_by' => $this->created_by,
            'assaign_to' => $this->assaign_to,
            'priority' => $this->priority ? 'High' : 'Low',
            'created' => $this->created_at->format('Y-m-d'),
            'updated' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
