<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Unit;
use League\Fractal\TransformerAbstract;

class UnitWithoutCompanyTransformer extends TransformerAbstract
{

    public function __construct(protected $authCompaniesTotal)
    {}

    /**
     * @param App\Models\Unit $unit
     * @return array
     */
    public function transform(Unit $unit): array
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

        $tag = null;
        if ($this->authCompaniesTotal > $unit->total_company) {
            $tag = Link::customLink('javascript:void(0)', 'la la-tags', 'Tag To Company', ['menu-link js-tag-modal-link', 'px-3'], 'data-id="' . $unit->id . '" data-dealer="' . $unit->as_dealer . '"');
        }

        $editLink = Link::edit(route('units.edit', [$unit->id]), 'Edit', ['menu-link', 'px-3']);

        $deleteLink = Link::delete(route('units.destroy', [$unit->id]), 'Are you sure to delete this unit?', ['menu-link', 'px-3']);

        return [
            'id' => (int) $unit->id,
            'code_name_type' => (string) $unit->code . '<br>' . (string) $unit->name . ' (' . (string) $unit->unit_type_name . ')',
            'compnaies' => (string) $unit->compnaies,
            'owner' => (string) $unit->owner . ' (' . (string) $unit->mobile . ')',
            'address' => (string) $address,
            'as_dealer' => $unit->as_dealer ? 'Yes' : 'No',
            'status' => (string) $unit->status,
            'action' => Link::generateDropdown($tag, $editLink, $deleteLink),
        ];
    }
}
