<?php

namespace App\Transformers;

use Carbon\Carbon;
use App\Abilities\Link;
use App\Models\EmergencyVisit;
use League\Fractal\TransformerAbstract;

class EmergencyVisitTransformer extends TransformerAbstract
{
    public function __construct(public array $nonEditableArray)
    {
    }
    /**
     * @param \App\Models\EmergencyVisit $visit
     * @return array
     */
    public function transform(EmergencyVisit $visit): array
    {

        $actionLinks = null;
        if (!in_array($visit->status, $this->nonEditableArray)) {
            // Create edit link
            $editLink = Link::edit(route('companies.emergencyvisits.edit', [$visit->company_id, $visit->id]));

            // Create delete link
            $deleteLink = Link::delete(route('companies.emergencyvisits.destroy', [$visit->company_id, $visit->id]));

            $actionLinks = Link::generate($editLink, $deleteLink);
        }
        return [
            'name' => (string) $visit->name,
            'unit' => (string) $visit->unit_code . ' <br> ' . $visit->unit_name . ' | ' . $visit->mobile,
            'zone' => (string) $visit->zone_name,
            'assign_to' => (string) $visit->assaign_to,
            'date_for' => Carbon::parse($visit->date_for)->format('jS M,Y'),
            'action' => $actionLinks,
        ];
    }
}
