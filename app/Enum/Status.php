<?php

namespace App\Enum;

use App\Http\Controllers\Traits\EnumToArray;

enum Status: string
{
    use EnumToArray;

    case Active = 'active';
    case Inactive = 'inactive';
}
