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
            'status' => str()->of($this->status)->replace("_", " ")->title(),
            'unit_type' => $this->unit_type,
            'unit_id' => $this->unit_id,
            'unit_name' => $this->unit_name,
            'company_name' => $this->company_name,
            'created_by' => $this->created_name,
            'assaign_to' => $this->assaigned_name,
            'created' => $this->created_at->format('jS M,Y'),
            'updated' => $this->updated_at->format('jS M,Y'),
            'started_at' => $this->started_at?->format('jS M,Y h:i a'),
            'started_time' => $this->started_at?->format('h:i a'),
            'completed_at' => $this->completed_at?->format('jS M,Y h:i a'),
            'completed_time' => $this->completed_at?->format('h:i a'),
        ];
    }
}
