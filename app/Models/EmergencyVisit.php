<?php

namespace App\Models;

use App\Enum\Status;
use App\Enum\VisitStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmergencyVisit extends BaseModel
{
    use HasFactory;
    protected $attributes = [
        'is_emergency_task' => true,
    ];
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('is_emergency_task', true);
        });
    }

    protected $table = 'visits';

    protected $guarded = ["id"];

    protected  function scopeNonEditableArray()
    {
        return [VisitStatus::OnGoing->value, VisitStatus::Completed->value];
    }

    public function scopeGetVisits($query, $request)
    {
        return $query->join('company_units', 'company_units.id', '=', 'visits.company_unit_id')
            ->join('zones', 'zones.id', '=', 'company_units.zone_id')
            ->join('units', 'units.id', '=', 'company_units.unit_id')
            ->join('companies', 'companies.id', '=', 'company_units.company_id')
            ->join('unit_types', 'unit_types.id', '=', 'visits.unit_type_id')
            ->join('users as created', 'created.id', '=', 'visits.created_by')
            ->leftJoin('users as assaigned', 'assaigned.id', '=', 'visits.assign_to')
            ->when($request->date_for, function ($q) use ($request) {
                $q->where('visits.date_for', $request->date_for);
            })
            ->when($request->company_id, function ($q) use ($request) {
                $q->where('companies.id', $request->company_id);
            })
            ->where(function ($q) use ($request) {
                $q->where('visits.assign_to', $request->user()->id)
                    ->orWhere('visits.created_by', $request->user()->id);
            })
            ->select(
                'visits.*',
                'zones.name as zone_name',
                'unit_types.name as unit_type',
                'units.id as unit_id',
                'units.name as unit_name',
                'units.code as unit_code',
                'units.mobile',
                'companies.name as company_name',
                'created.name as created_by',
                'assaigned.name as assaign_to'
            )
            ->get();
    }

    public function scopeGetVisitDetails($query, $request)
    {
        return $query->join('company_units', 'company_units.id', '=', 'visits.company_unit_id')
            ->join('units', 'units.id', '=', 'company_units.unit_id')
            ->join('companies', 'companies.id', '=', 'company_units.company_id')
            ->join('unit_types', 'unit_types.id', '=', 'company_units.unit_type_id')
            ->join('users as created', 'created.id', '=', 'visits.created_by')
            ->leftJoin('users as assaigned', 'assaigned.id', '=', 'visits.assign_to')
            ->where('visits.id', $request->id)
            ->select(
                'visits.*',
                'unit_types.name as unit_type',
                'units.id as unit_id',
                'units.name as unit_name',
                'companies.name as company_name',
                'created.name as created_by',
                'assaigned.name as assaign_to'
            )
            ->first();
    }
}
