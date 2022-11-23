<?php

namespace App\View\Components;

use App\Models\District;
use Illuminate\View\Component;

class UnitHeadComp extends Component
{
    public $unit;

    public function __construct($unit = null)
    {
        $this->unit = $unit;
    }

    public function districts()
    {
        return District::getList()->pluck('name', 'id');
    }

    public function unitTypes()
    {
        return resolve('authUnitTypes');
    }

    public function countUnitTypes(): Int
    {
        return (int) $this->unitTypes()->count();
    }

    public function className(): String
    {
        if ($this->countUnitTypes() == 1) {
            return 'col-md-6';
        }
        return 'col-md-4';
    }

    public function getSlectedArr()
    {
        if (old() && count(old())) {
            return [
                'unitName' => old('name'),
                'mobile' => old('mobile'),
                'districtId' => old('district_id'),
                'upazilaId' => old('upazila_id'),
            ];
        } elseif ($this->unit && $this->unit->id) {
            return [
                'unitName' => $this->unit->name,
                'mobile' => $this->unit->mobile,
                'districtId' => $this->unit->district_id,
                'upazilaId' => $this->unit->upazila_id,
            ];
        } else {
            return [
                'unitName' => '',
                'mobile' => '',
                'districtId' => 0,
                'upazilaId' => 0,
            ];
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.unit-head-comp');
    }
}
