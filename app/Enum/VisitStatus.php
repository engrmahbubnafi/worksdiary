<?php

namespace App\Enum;

use Illuminate\Support\Arr;
use App\Http\Controllers\Traits\EnumToArray;

enum VisitStatus: string
{
    use EnumToArray;

    case WaitingForApproval = 'waiting';
    case Approved = 'approved';
    case OnGoing = 'ongoing';
    case Postponed = 'postponed';
    case Completed = 'completed';
}
