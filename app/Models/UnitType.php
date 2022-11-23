<?php

namespace App\Models;

use App\Enum\Status;
use App\Models\BaseModel;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class UnitType extends BaseModel
{
    use HasFactory;
    protected $guarded = ["id"];

    public function children()
    {
        return $this->hasMany(UnitType::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(UnitType::class, 'parent_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_unit_types', 'unit_type_id', 'department_id');
    }

    public function scopeWhereDepartmentId($query, $department_id)
    {
        return $query->where('department_unit_types.department_id', $department_id);
    }

    public function scopeGetUnitTypeByUserCompany($query, $company = []): Collection
    {
        return $query->join('department_unit_types', 'department_unit_types.unit_type_id', '=', 'unit_types.id')
            ->join('departments', 'departments.id', '=', 'department_unit_types.department_id')
            ->whereIn('company_id', $company)
            ->select('unit_types.id', 'unit_types.name')
            ->get();
    }


    public function scopeAuthUnitTypes($query, int|null $unitTypeId = null)
    {
        $query->with(['children' => function ($q) {
            $q->select(
                'unit_types.id',
                'unit_types.name',
                'unit_types.parent_id',
                'unit_types.is_slot_enabled'
            )
                ->where('unit_types.status', Status::Active);
        }])
            ->join('department_unit_types', 'department_unit_types.unit_type_id', '=', 'unit_types.id')
            ->join('departments', 'departments.id', 'department_unit_types.department_id')
            ->select(
                'unit_types.id',
                'unit_types.name',
                'unit_types.parent_id',
                'unit_types.is_slot_enabled'
            )
            ->where('department_unit_types.department_id', auth()->user()->department_id)
            ->where('unit_types.status', Status::Active);

        if ($unitTypeId) {
            $query->where('unit_types.id', $unitTypeId);
        }

        return $query->get();
    }

    public function scopeAuthUnitTypesAll($query, int|null $unitTypeId = null)
    {
        $unitTypes = self::authUnitTypes($unitTypeId);

        $unitTypesIds = [];
        if ($unitTypes->count()) {
            foreach ($unitTypes as $unitType) {
                if ($unitType->children->count()) {
                    foreach ($unitType->children as $child) {
                        $unitTypesIds[$child->id] = $child->name;
                    }
                } else {
                    $unitTypesIds[$unitType->id] = $unitType->name;
                }
            }
        }

        ksort($unitTypesIds);

        return collect($unitTypesIds);
    }

    public function scopeAuthUnitTypesAllForApi($query, int|null $unitTypeId = null)
    {

        $unitTyepsArr = collect();

        $unitTypes = self::authUnitTypes($unitTypeId);

        if ($unitTypes->count()) {
            foreach ($unitTypes as $unitType) {
                if ($unitType->children->count()) {
                    foreach ($unitType->children as $child) {
                        $unitTyepsArr->push(
                            [
                                'id' => $child->id,
                                'name' => $child->name,
                                'slotable' => !!$child->is_slot_enabled
                            ]
                        );
                    }
                } else {
                    $unitTyepsArr->push(
                        [
                            'id' => $unitType->id,
                            'name' => $unitType->name,
                            'slotable' => !!$unitType->is_slot_enabled
                        ]
                    );
                }
            }
        }

        $sorted = $unitTyepsArr->sortBy('id');

        return (new EmptyObj())->hydrate($sorted->values()->all());
    }
}
