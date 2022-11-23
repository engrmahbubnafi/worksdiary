<?php

namespace App\Models;

use App\Enum\Status;
use App\Abilities\UnitName;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyUnit extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    public function unit(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => (new UnitName($attributes))(),
        );
    }

    /**
     * Get units for data with company taging.
     *
     * @param int $companyId
     * */
    public function scopeGetDataWithCompanyTaging($query, $request, int $companyId): Collection
    {

        $unitTypesIds = DepartmentUnitType::getUserUnitTypesIds();

        if ($request->exists('zone_id') && $request->has('zone_id')) {
            $zoneId = $request->get('zone_id');
            $authZones = collect();
        } else {
            $zoneId = null;
            $authZones = Zone::getZones($request, $companyId);
        }

        return $query->select(
            'units.*',
            'company_units.id as company_unit_id',
            'unit_types.name as unit_type_name',
            'districts.name as district_name',
            'upazilas.name as upazila_name',
            'companies.name as company_name',
            'zones.name as zone_name',
            'areas.name as area_name',
            'dealers.name as dealer_name',
            'dealers.mobile as dealer_mobile'
        )
            ->join('units', 'units.id', 'company_units.unit_id')
            ->join('unit_types', 'unit_types.id', 'units.unit_type_id')
            ->join('districts', 'districts.id', 'units.district_id')
            ->join('upazilas', 'upazilas.id', 'units.upazila_id')
            ->join('companies', 'companies.id', 'company_units.company_id')
            ->leftJoin('zones', 'zones.id', 'company_units.zone_id')
            ->leftJoin('areas', 'areas.id', 'company_units.area_id')
            ->leftJoin('units as dealers', function ($query) {
                $query->on('dealers.id', 'company_units.dealer_id')
                    ->where('dealers.as_dealer', true);
            })
            ->when($zoneId, function ($q) use ($zoneId) {
                $q->where('company_units.zone_id', $zoneId);
            })
            ->when(!$zoneId && $authZones->count(), function ($q) use ($authZones) {
                $q->whereIn('company_units.zone_id', $authZones->pluck('id', 'id'));
            })
            ->where('company_units.company_id', $companyId)
            ->whereIn('unit_types.id', $unitTypesIds)
            ->get();
    }

    public function scopeList($query, $request)
    {
        $companyId = $request->company_id;

        $unitTypesIds = DepartmentUnitType::getUserUnitTypesIds();


        if ($request->exists('zone_id') && $request->has('zone_id')) {
            $zoneId = $request->get('zone_id');
            $authZones = collect();
        } else {
            $zoneId = null;
            $authZones = Zone::getZones($request, $companyId);
        }


        return $query->select(
            'units.id',
            'units.name',
            'units.code',
            'units.mobile',
            'units.owner',
            'units.unit_type_id',
            'units.as_dealer',
            'company_units.id as company_unit_id',
            'unit_types.name as unit_type_name',
            'companies.name as company_name',
        )
            ->join('units', 'units.id', '=', 'company_units.unit_id')
            ->join('companies', 'companies.id', '=', 'company_units.company_id')
            ->join('unit_types', 'unit_types.id', '=', 'units.unit_type_id')

            ->when($zoneId, function ($q) use ($zoneId) {
                $q->where('company_units.zone_id', $zoneId);
            })
            ->when(!$zoneId && $authZones->count(), function ($q) use ($authZones) {
                $q->whereIn('company_units.zone_id', $authZones->pluck('id', 'id'));
            })
            ->where('company_units.company_id', $companyId)
            ->where('company_units.status', Status::Active)
            ->whereIn('unit_types.id', $unitTypesIds)
            ->get();
    }
}
