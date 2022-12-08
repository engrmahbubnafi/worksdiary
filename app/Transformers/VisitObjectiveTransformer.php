<?php

namespace App\Transformers;

use App\Models\VisitObjective;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class VisitObjectiveTransformer extends TransformerAbstract
{
    /**
     * @param \App\Models\VisitObjective $visitObjective
     * @return array
     */
    public function transform(VisitObjective $visitObjective): array
    {
        return [
            'id' => (int) $visitObjective->id,
            'title' => (string) $visitObjective->title,
            'status' => (string) Str::ucfirst($visitObjective->status),
        ];
    }
}
