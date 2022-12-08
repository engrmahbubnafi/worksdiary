<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Enum\EmergencyVisitStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmergencyVisit extends BaseModel
{
    use HasFactory;

    protected $table = 'emergency_tasks';

    protected $guarded = ["id"];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    public function emergencyTaskImages()
    {
        return $this->hasMany(EmergencyTaskImage::class, 'emergency_task_id');
    }

    protected  function scopeNonEditableArray()
    {
        return [EmergencyVisitStatus::Canceled->value, EmergencyVisitStatus::Completed->value];
    }

    public function scopeGetVisitsEloquentObjWithOutSelect($query, $request)
    {
        return $query->join('company_units', 'company_units.id', '=', 'emergency_tasks.company_unit_id')
            ->join('zones', 'zones.id', '=', 'company_units.zone_id')
            ->join('units', 'units.id', '=', 'company_units.unit_id')
            ->join('companies', 'companies.id', '=', 'company_units.company_id')
            ->join('unit_types', 'unit_types.id', '=', 'emergency_tasks.unit_type_id')
            ->join('users as created', 'created.id', '=', 'emergency_tasks.created_by')
            ->join('users as assaigned', 'assaigned.id', '=', 'emergency_tasks.assign_to')
            ->leftJoin('users as supervisor', 'supervisor.id', '=', 'assaigned.supervisor_id')
            ->when($request->date_for, function ($q) use ($request) {
                $segments = Str::of($request->date_for)->split('/\|/');

                if (!empty($segments[0]) && !empty($segments[1])) {
                    $min = Carbon::parse($segments[0]);
                    $max = Carbon::parse($segments[1]);

                    $q->whereBetween('emergency_tasks.date_for', [$min, $max]);
                }
            })
            ->when($request->company_id, function ($q) use ($request) {
                $q->where('companies.id', $request->company_id);
            })
            ->when(
                $request->supervisor_id,
                function ($q) use ($request) {
                    $q->where('assaigned.supervisor_id', $request->supervisor_id);
                },
                function ($q) use ($request) {
                    $q->where(function ($q1) use ($request) {
                        $q1->where('emergency_tasks.assign_to', $request->user()->id)
                            ->orWhere('emergency_tasks.created_by', $request->user()->id)
                            ->orWhere('assaigned.supervisor_id', $request->user()->id);
                    });
                }
            )
            ->when($request->status, function ($q) use ($request) {
                $q->where('emergency_tasks.status', $request->status);
            });
    }
    public function scopeGetVisitsEloquentObj($query, $request)
    {
        return $this->getVisitsEloquentObjWithOutSelect($request)
            ->select(
                'emergency_tasks.*',
                'zones.name as zone_name',
                'unit_types.name as unit_type',
                'units.name as unit_name',
                'units.code as unit_code',
                'units.mobile',
                'companies.name as company_name',
                'created.name as created_name',
                'assaigned.name as assaigned_name',
                'supervisor.name as supervisor_name'
            );
    }

    public function scopeGetVisits($query, $request)
    {
        return self::getVisitsEloquentObj($request)
            ->get();
    }

    public function scopeGetVisit($query, $request)
    {
        return self::getVisitsEloquentObj($request)
            ->find($request->id);
    }

    public function scopeGetVisitDetails($query, $request)
    {
        return $query->join('company_units', 'company_units.id', '=', 'emergency_tasks.company_unit_id')
            ->join('units', 'units.id', '=', 'company_units.unit_id')
            ->join('companies', 'companies.id', '=', 'company_units.company_id')
            ->join('unit_types', 'unit_types.id', '=', 'company_units.unit_type_id')
            ->join('users as created', 'created.id', '=', 'emergency_tasks.created_by')
            ->leftJoin('users as assaigned', 'assaigned.id', '=', 'emergency_tasks.assign_to')
            ->where('emergency_tasks.id', $request->id)
            ->select(
                'emergency_tasks.*',
                'unit_types.name as unit_type',
                'units.name as unit_name',
                'companies.name as company_name',
                'created.name as created_name',
                'assaigned.name as assaigned_name'
            )
            ->first();
    }
}
