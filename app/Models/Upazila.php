<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Upazila extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeGetByDistrict($query, int $districtId = null)
    {
        return $query->select(
            'id',
            DB::raw('CONCAT(name," (",bn_name,")") as name')
        )
            ->where('district_id', $districtId)
            ->get();
    }
}