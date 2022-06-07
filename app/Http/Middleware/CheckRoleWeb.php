<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleWeb
{
    public function __construct()
    {
        //
    }

    public function handle($request, Closure $next, ...$args)
    {
        if (!(in_array(auth()->user()->role, $args))) {
            return abort(404);
        }

        return $next($request);
    }
}
