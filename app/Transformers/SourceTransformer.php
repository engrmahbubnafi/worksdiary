<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Source;
use League\Fractal\TransformerAbstract;

class SourceTransformer extends TransformerAbstract
{
    /**
     * @param \App\Source $source
     * @return array
     */
    public function transform(Source $source): array
    {
        // New source detail
        $newSourceDetail = Link::customLink(route('sources.source-details.create', [$source->id]), 'la la-plus', 'New Source Detail');

        // Create source details listing link
        $sourceDetailsList = Link::customLink(route('sources.source-details.index', [$source->id]), 'la la-list', 'Source Details');

        // Get unit type name
        $unitTypeName = Source::leftJoin('unit_types', 'sources.unit_type_id', 'unit_types.id')
            ->select('unit_types.name')
            ->where('unit_type_id', $source->unit_type_id)
            ->pluck('name')
            ->first();

        // Create edit link
        $editLink = Link::edit(route('companies.sources.edit', [$source->company_id, $source->id]));

        // Create delete link
        $deleteLink = Link::delete(route('companies.sources.destroy', [$source->company_id, $source->id]));

        return [
            'id' => (int) $source->id,
            'name' => (string) $source->name,
            'unit_type' => (string) $unitTypeName,
            'action' => Link::generate($newSourceDetail, $sourceDetailsList, $editLink, $deleteLink),
        ];
    }
}
