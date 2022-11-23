<?php

namespace App\Http\Middleware;

use Closure;
use App\Enum\Status;
use Illuminate\Support\Facades\Redirect;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if ($request->user() && ($request->user()->status != Status::Active)) {
            return $request->expectsJson()
                ? abort(403, 'Your profile is waiting for administrator approval')
                : Redirect::route($redirectToRoute ?: 'account.activation.process');
        }
        return $next($request);
    }
}
