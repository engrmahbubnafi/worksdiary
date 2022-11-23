<?php

namespace App\Models;

use App\Enum\Status;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SourceDetail extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeGetSourceDetailsBySourceId($query, int $source_id, $reference_value = null)
    {

        $queryObj = $query->select('id', 'value')
            ->where('status', Status::Active)
            ->where('source_id', $source_id);

        if ($reference_value) {
            $queryObj2 = clone $queryObj;

            return ($queryObj->where('from', '<=', $reference_value)->where('to', '>=', $reference_value)->first()) ??
                ($queryObj2->where('is_default', true)->first()) ??
                (new SourceDetail())->setRawAttributes(['id' => null, 'value' => null]);
        }

        return $queryObj->get();
    }
}
