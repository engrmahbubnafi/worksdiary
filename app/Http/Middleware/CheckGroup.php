<?php

namespace App\Http\Middleware;

use Closure;

class CheckGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $group, $isAdmin = null)
    {

        if (
            $isAdmin
            &&
            $request->user()->group_type == $isAdmin
        ) {
            return $next($request);
        }

        $param = $request->route($group);

        // dd($param);

        if (
            !is_numeric($param)
            &&
            substr($param, 0, 2) != 'ML'
            &&
            $request->user()->group_type !== $group
        ) {
            return redirect()->route('home', 'home');
        }

        return $next($request);
    }
}
