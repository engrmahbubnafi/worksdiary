<?php

namespace App\Enum;

use Illuminate\Support\Arr;
use App\Http\Controllers\Traits\EnumToArray;

enum VisitStatus: string
{
    use EnumToArray;

    case WaitingForApproval = 'waiting_for_approval';
    case Approved = 'approved';
    case OnGoing = 'on_going';
    case Paused = 'paused';
    case Postponed = 'postponed';
    case Completed = 'completed';
}
