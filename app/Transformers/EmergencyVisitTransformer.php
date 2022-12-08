<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\EmergencyVisit;
use Carbon\Carbon;
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
    public function transform(EmergencyVisit $emergencyVisit): array
    {
        $actionLinks = null;
        $viewLink = Link::show(route('companies.emergencyvisits.show', [$emergencyVisit->company_id, $emergencyVisit->id]));
        if (!in_array($emergencyVisit->status, $this->nonEditableArray)) {
            // Create edit link
            $editLink = Link::edit(route('companies.emergencyvisits.edit', [$emergencyVisit->company_id, $emergencyVisit->id]));

            // Create delete link
            $deleteLink = Link::delete(route('companies.emergencyvisits.destroy', [$emergencyVisit->company_id, $emergencyVisit->id]));

            $actionLinks = Link::generate($viewLink, $editLink, $deleteLink);
        } else {
            $actionLinks = Link::generate($viewLink);
        }
        return [
            'id' => (int) $emergencyVisit->id,
            'name' => (string) $emergencyVisit->name,
            'unit' => (string) $emergencyVisit->unit_code . ' <br> ' . $emergencyVisit->unit_name . ' | ' . $emergencyVisit->mobile,
            'zone' => (string) $emergencyVisit->zone_name,
            'assign_to' => (string) $emergencyVisit->assaigned_name,
            'status' => (string) $emergencyVisit->status,
            'date_for' => Carbon::parse($emergencyVisit->date_for)->format('jS M,Y'),
            'created_at' => Carbon::parse($emergencyVisit->created_at)->format('jS M,Y'),
            'created_by' => (string) $emergencyVisit->created_name,
            'action' => $actionLinks,
        ];
    }
}
