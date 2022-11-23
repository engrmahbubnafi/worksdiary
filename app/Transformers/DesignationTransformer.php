<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Designation;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class DesignationTransformer extends TransformerAbstract
{
    public function transform(Designation $designation): array
    {
        $editLink = Link::edit(route('designations.edit', [$designation->id]));
        $deleteLink = Link::delete(route('designations.destroy', [$designation->id]), message:'Are you sure to delete this designation?');
        return [
            'id' => (int) $designation->id,
            'name' => (string) $designation->name,
            'status' => (string) Str::ucfirst($designation->status),
            'action' => Link::generate($editLink, $deleteLink),
        ];
    }
}
