<?php

namespace App\Models;

use App\Enum\Status;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FieldGroup extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('field_groups.status', Status::Active);
    }
}
