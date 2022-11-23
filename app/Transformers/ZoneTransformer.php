<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Zone;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class ZoneTransformer extends TransformerAbstract
{
    /**
     * @param \App\Models\Zone $zone
     * @return array
     */
    public function transform(Zone $zone): array
    {

        $addArea = Link::customLink(route('companies.zones.areas.create', [$zone->company_id, $zone->id]), 'la la-plus', "Add Area", ['menu-link', 'px-3']);

        // Create area listing link
        $areaList = Link::customLink(route('companies.zones.areas.index', [$zone->company_id, $zone->id]), 'la la-list', "Areas List", ['menu-link', 'px-3']);

        // Create edit link
        $editLink = Link::edit(route('companies.zones.edit', [$zone->company_id, $zone->id]), 'Edit', ['menu-link', 'px-3']);

        // Create delete link
        $deleteLink = Link::delete(route('companies.zones.destroy', [$zone->company_id, $zone->id]), 'Are you sure to delete this zone?', ['menu-link', 'px-3']);

        return [
            'id' => $zone->id,
            'name' => $zone->name,
            'status' => Str::ucfirst($zone->status),
            'action' => Link::generateDropdown($addArea, $areaList, $editLink, $deleteLink),
        ];
    }
}
