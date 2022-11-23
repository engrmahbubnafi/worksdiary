<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\SourceDetail;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class SourceDetailTransformer extends TransformerAbstract
{
    /**
     * @param \App\SourceDetail $sourceDetail
     * @return array
     */
    public function transform(SourceDetail $sourceDetail): array
    {
        $editLink = Link::edit(route('sources.source-details.edit', [$sourceDetail->source_id, $sourceDetail->id]));
        $deleteLink = Link::delete(route('sources.source-details.destroy', [$sourceDetail->source_id, $sourceDetail->id]));

        if ($sourceDetail->is_default == 0) {
            $isDefault = 'Not default';
        } else {
            $isDefault = 'Default';
        }

        return [
            'id' => (int) $sourceDetail->id,
            'source_id' => $sourceDetail->name,
            'from' => (string) $sourceDetail->from,
            'to' => (string) $sourceDetail->to,
            'value' => (string) $sourceDetail->value,
            'is_default' => (string) Str::ucfirst($isDefault),
            'status' => (string) Str::ucfirst($sourceDetail->status),
            'action' => Link::generate($editLink, $deleteLink),
        ];
    }
}
