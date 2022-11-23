<?php

namespace App\Models;

use App\Events\ModelCreating;
use App\Events\ModelUpdating;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $dispatchesEvents = [
        'creating' => ModelCreating::class,
        'updating' => ModelUpdating::class,
    ];

}
