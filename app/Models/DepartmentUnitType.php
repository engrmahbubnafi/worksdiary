<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class DepartmentUnitType extends BaseModel
{
    use HasFactory;

    public function scopeWhereUnitTypeId($query, $unit_type_id)
    {
        return $query->where('unit_type_id', $unit_type_id);
    }

    /**
     * For searching and viewing units or company units
     *
     * @param [type] $query
     * @return Collection
     */

    public function scopeGetUserUnitTypesIds($query): Collection
    {
        $unitTypes = $query->join('departments', 'departments.id', 'department_unit_types.department_id')
            ->join('unit_types', 'unit_types.id', 'department_unit_types.unit_type_id')
            ->select(
                'unit_types.id',
                'unit_types.parent_id'
            )
            ->where('department_unit_types.department_id', auth()->user()->department_id)
            ->get();

        $unitTypesIds = [];
        if ($unitTypes->count()) {
            foreach ($unitTypes as $unitType) {
                $unitTypesIds[$unitType->id] = $unitType->id;
                if ($unitType->parent_id) {
                    $unitTypesIds[$unitType->parent_id] = $unitType->parent_id;
                }
            }
        }
        return collect($unitTypesIds);
    }

}
