<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\UnitType;
use League\Fractal\TransformerAbstract;

class UnitTypeTransformer extends TransformerAbstract
{
    /**
     * @param \App\UnitType $unitType
     * @return array
     */
    public function transform(UnitType $unitType): array
    {
        $editLink = Link::edit(route('unit-types.edit', [$unitType->id]));
        $deleteLink = Link::delete(route('unit-types.destroy', [$unitType->id]));

        return [
            'id' => (int) $unitType->id,
            'name' => (string) $unitType->name,
            'parent' => (string) $unitType->parent?->name,
            'departments' => (string) $unitType->department,
            'is_slot_enabled' => $unitType->is_slot_enabled ? 'Yes' : 'No',
            'status' => ucfirst($unitType->status),
            'action' => Link::generate($editLink, $deleteLink),
        ];
    }
}
