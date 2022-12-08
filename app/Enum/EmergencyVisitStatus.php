<?php

namespace App\Enum;

use App\Http\Controllers\Traits\EnumToArray;

enum EmergencyVisitStatus: string
{
    use EnumToArray;

    case Pending = 'pending';
    case Canceled = 'canceled';
    case Completed = 'completed';
}
