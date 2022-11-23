<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Area;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class AreaTransformer extends TransformerAbstract
{

    public function __construct(protected $companyId)
    {}

    /**
     * @param \App\Models\Area $area
     * @return array
     */
    public function transform(Area $area): array
    {
        // Create edit link
        $editLink = Link::edit(route('companies.zones.areas.edit', [$this->companyId, $area->zone_id, $area->id]));

        // Create delete link
        $deleteLink = Link::delete(route('companies.zones.areas.destroy', [$this->companyId, $area->zone_id, $area->id]), message:'Are you sure to delete this area?');

        return [
            'id' => (int) $area->id,
            'name' => (string) $area->name,
            'zone' => (string) $area->zone_name,
            'status' => (string) Str::ucfirst($area->status),
            'action' => Link::generate($editLink, $deleteLink),
        ];
    }
}
