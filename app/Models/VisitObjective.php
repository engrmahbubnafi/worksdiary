<?php

namespace App\Models;

use App\Enum\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitObjective extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeGetTitles($query, $request)
    {
        return $query->select(
            'visit_objectives.title'
        )
            ->where('visit_objectives.company_id', $request->company_id)
            ->where('visit_objectives.status', Status::Active)
            ->get();
    }
}
