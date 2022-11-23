<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class District extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeGetList($query)
    {
        return $query->select(
            'id',
            DB::raw('CONCAT(name," (",bn_name,")") as name')
        )
            ->orderBy('name')
            ->get();
    }
}