<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends BaseModel
{
    use HasFactory;
    protected $guarded = ["id"];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    public function unitTypes()
    {
        return $this->belongsToMany(UnitType::class, 'department_unit_types', 'department_id', 'unit_type_id');
    }
}
