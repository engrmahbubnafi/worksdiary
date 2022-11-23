<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DenyForThirdParty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->is_third_party) {
            return $request->expectsJson()
            ? abort(403, 'You are not allowed for requesting page')
            : redirect()->back()->with('flash_warning', 'You are not allowed for requesting page');
        }
        return $next($request);
    }
}