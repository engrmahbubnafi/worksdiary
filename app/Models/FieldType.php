<?php

namespace App\Models;

use App\Enum\Status;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FieldType extends BaseModel
{
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->where('field_types.status', Status::Active);
    }
}
