<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use League\Fractal\TransformerAbstract;

class VisitTransformer extends TransformerAbstract
{

    public function __construct(public array $nonEditableArray)
    {
    }
    /**
     * @param \App\Models\Visit $visit
     * @return array
     */

    public function transform(Visit $visit): array
    {
        $actionLinks = null;
        $viewLink = Link::show(route('companies.visits.show', [$visit->company_id, $visit->id]));

        if (!in_array($visit->status, $this->nonEditableArray)) {
            // Create edit link
            $editLink = Link::edit(route('companies.visits.edit', [$visit->company_id, $visit->id]));

            // Create delete link
            $deleteLink = Link::delete(route('companies.visits.destroy', [$visit->company_id, $visit->id]));

            $actionLinks = Link::generate($viewLink, $editLink, $deleteLink);
        } else {
            $actionLinks = Link::generate($viewLink);
        }

        return [
            'id' => (int) $visit->id,
            'name' => (string) $visit->name,
            'unit' => (string) $visit->unit_code . ' <br> ' . $visit->unit_name . ' | ' . $visit->mobile,
            'zone' => (string) $visit->zone_name,
            'assign_to' => (string) $visit->assaigned_name,
            'status' => (string) $visit->status,
            'date_for' => Carbon::parse($visit->date_for)->format('jS M,Y'),
            'created_at' => Carbon::parse($visit->created_at)->format('jS M,Y'),
            'created_by' => (string) $visit->created_name,
            'action' => $actionLinks,
        ];
    }
}
