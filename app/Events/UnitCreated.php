<?php

namespace App\Events;

use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class UnitCreated
{

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        if (Schema::hasColumn($model->getTable(), 'code')) {
            $district = District::find($model->district_id);
            if ($district) {
                $preCode = strtoupper(substr($district->name, 0, 4));
                $postCode = str_pad($model->id, 6, "0", STR_PAD_LEFT);
                $model->code = $preCode . '-' . $postCode;
                $model->update();
            }
        }

    }

}
