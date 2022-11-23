<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\CompanyUnit;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class UnitWithCompanyTransformer extends TransformerAbstract
{
    public function __construct(protected $companyId)
    {}

    /**
     * @param App\Models\Unit $unit
     * @return array
     */
    public function transform(CompanyUnit $unit): array
    {

        $address = '';
        if (!empty($unit->district_name)) {
            $address .= $unit->district_name . ', ';
        }

        if (!empty($unit->upazila_name)) {
            $address .= $unit->upazila_name . ', ';
        }

        if (!empty($unit->address)) {
            $address .= $unit->address;
        }

        $location = '';
        if (!empty($unit->zone_name)) {
            $location .= $unit->zone_name . ', ';
        }

        if (!empty($unit->area_name)) {
            $location .= $unit->area_name;
        }

        $status = Str::ucfirst($unit->status);

        $editLink = Link::edit(route('companies.units.tag.edit', [$this->companyId, $unit->id]), 'Edit Tag', ['menu-link', 'px-3']);
        $untagLink = Link::delete(route('companies.units.untag', [$this->companyId, $unit->id]), 'Are you sure you want to untag?', ['menu-link', 'px-3'], 'Untag');

        return [
            'id' => (int) $unit->id,
            'code_name_type' => (string) $unit->code . '<br>' . (string) $unit->name . ' (' . (string) $unit->unit_type_name . ')',
            'company_name' => (string) $unit->company_name,
            'owner' => (string) $unit->owner . ' (' . (string) $unit->mobile . ')',
            'address' => (string) $address,
            'location' => (string) $location,
            'dealer' => $unit->dealer_name ? (string) $unit->dealer_name . ' (' . (string) $unit->dealer_mobile . ')' : '',
            'as_dealer' => $unit->as_dealer ? 'Yes' : 'No',
            'status' => (string) $status,
            'action' => Link::generateDropdown($editLink, $untagLink),
        ];
    }
}
