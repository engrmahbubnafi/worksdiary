<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ModelCreating
{

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        if (Schema::hasColumn($model->getTable(), 'created_by')) {
            $model->created_by = auth()->id();
        }

    }

}
