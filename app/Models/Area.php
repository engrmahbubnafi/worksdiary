<?php

namespace App\Models;

use App\Enum\Status;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends BaseModel
{
    use HasFactory;

    protected $guarded = ["id"];

    public function scopeGetAreasByZone($query, $zone_id, $unit_type_id = null)
    {

        if (!$zone_id) {
            return collect();
        }

        return $query->where('zone_id', $zone_id)
            ->when($unit_type_id, function ($query, $unit_type_id) {
                $query->where('unit_type_id', $unit_type_id);
            })
            ->where('status', Status::Active)
            ->select('id', 'name')
            ->get();
    }
}
