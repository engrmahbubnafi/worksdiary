<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dealer extends BaseModel
{
    use HasFactory;
    protected $guarded = ["id"];
}
