<?php

namespace App\Models;

use App\Enum\Status;
use App\Models\Field;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('forms.status', Status::Active);
    }

    public function scopeFormList($query, $user_id, $companyId)
    {
        return $query->join('companies', 'companies.id', '=', 'forms.company_id')
            ->join('company_users', 'companies.id', '=', 'company_users.company_id')
            ->join('unit_types', 'unit_types.id', '=', 'forms.unit_type_id')
            ->where('company_users.user_id', $user_id)
            ->where('forms.company_id', $companyId)
            ->select(
                'forms.id',
                'forms.name',
                'forms.company_id',
                'forms.unit_type_id',
                'forms.number_of_fields',
                'forms.is_multiple',
                'forms.time_duration_unit',
                'forms.status',
                'companies.name as company',
                'unit_types.name as unit_type'
            )
            ->get();
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
