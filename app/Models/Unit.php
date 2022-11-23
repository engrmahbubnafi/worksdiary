<?php

namespace App\Models;

use App\Enum\Status;
use App\Models\BaseModel;
use App\Events\UnitCreated;
use App\Models\CompanyUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends BaseModel
{
    use HasFactory;
    protected $guarded = ["id"];

    protected $dispatchesEvents = [
        'created' => UnitCreated::class,
    ];

    public function type()
    {
        return $this->belongsTo(UnitType::class);
    }

    public function companies()
    {
        return $this->hasMany(CompanyUnit::class);
    }

    public function scopeGetDealerListByCompany($query, $company_id)
    {
        return $query->join('company_units', 'company_units.unit_id', '=', 'units.id')
            ->where('company_id', $company_id)
            ->where('as_dealer', true)
            ->pluck('units.name', 'units.id');
    }

    public function scopeGetUnitByCompanyUnitType($query, $mobile, $companyId, $unitTypeId)
    {
        return $query->leftJoin('company_units', 'units.id', '=', 'company_units.unit_id')
            ->where('units.mobile', $mobile)
            ->select(
                'units.*'
            )
            ->get();
    }

    public function scopeGetUnitListBySearchParam($query, $request)
    {

        if (!empty($request['search_text'])) {
            $query->where('units.status', Status::Active)
                ->where(function ($que) use ($request) {
                    $que->whereFullText('units.name', $request['search_text'])
                        //->whereRaw("MATCH(units.name) AGAINST('+{$request['full_text_string']}' IN BOOLEAN MODE)")
                        ->orWhere('units.code', 'like', '%' . $request['search_text'] . '%')
                        ->orWhere('units.mobile', 'like', '%' . $request['search_text'] . '%');
                })
                ->select(
                    'units.id',
                    'units.code',
                    'units.name',
                    'units.mobile',
                    'units.as_dealer'
                );

            if (isset($request['company_id']) && !empty($request['company_id'])) {

                $sub = CompanyUnit::select('company_units.unit_id')
                    ->where('company_units.company_id', $request['company_id']);

                $query->leftJoinSub($sub, 'company_units', function ($join) {
                    $join->on('company_units.unit_id', '=', 'units.id');
                })
                    ->whereNull('company_units.unit_id');
            }

            if (isset($request['by_unit_id']) && !empty($request['by_unit_id'])) {
                $query->where('units.id', '<>', $request['by_unit_id'])
                    ->where('units.as_dealer', true);
            }

            if (isset($request['district_id']) && !empty($request['district_id'])) {
                $query->where('units.district_id', $request['district_id']);
            }

            if (isset($request['unit_types']) && count($request['unit_types'])) {
                $query->whereIn('units.unit_type_id', $request['unit_types']);
            }

            return $query->get();
        }

        return collect();
    }

    public function scopeGetUnitsByCompanyOrId($query, $request)
    {
        $result = collect();
        $queryObj = $query->join('districts', 'districts.id', '=', 'units.district_id')
            ->join('upazilas', 'upazilas.id', '=', 'units.upazila_id')
            ->select(
                'units.id',
                'units.name',
                'units.code',
                'units.owner',
                'units.mobile',
                'districts.name as district',
                'upazilas.name as upazila'
            )
            ->where('units.status', Status::Active);

        if ($request->has('id')) {

            $result = $queryObj->where('id', $request['id'])->first();
        } elseif ($request->has('id') && $request->has('company_id')) {

            $result = $queryObj->join('company_units', 'units.id', '=', 'company_units.unit_id')
                ->where('id', $request['id'])
                ->where('company_units.company_id', $request['company_id'])
                ->where('company_units.status', Status::Active)
                ->first();
        }
        return $result;
    }
}
