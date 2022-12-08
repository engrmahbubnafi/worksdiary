<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'code' => $this->code,
            'role' => $this->role->name,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'avatar' => asset('storage' . DIRECTORY_SEPARATOR . str_replace('\\', '/', $this->avatar)),
            'designation' => $this->designation?->name,
            'department' => $this->department?->name,
            'company' => new CompanyResource($this->company),
            'supervisor' => $this->supervisor?->name,
            'created' => $this->created_at->format('Y-m-d'),
            'updated' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
