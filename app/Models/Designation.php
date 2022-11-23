<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends BaseModel
{
    use HasFactory;
    protected $guarded = ["id"];
}
