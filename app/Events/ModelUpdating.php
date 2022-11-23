<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ModelUpdating
{

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $model)
    {

        if (Schema::hasColumn($model->getTable(), 'updated_by')) {
            $model->updated_by = auth()->id();
        }

    }

}
