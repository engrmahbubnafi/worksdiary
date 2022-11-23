<?php

namespace App\Models;

use App\Enum\Status;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends BaseModel
{
    use HasFactory;

    protected $guarded = ["id"];


    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function scopeGetCompanyWithDepartmentByCompanyId($query, $companiesArr = array())
    {
        return $query->with(['departments' => function ($q) {
            return $q->select('id', 'company_id', 'name');
        }])
            ->whereIn('id', $companiesArr)
            ->select('id', 'name', 'code')
            ->get();
    }
}
