<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonOnly
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //406
        abort_if(!$request->expectsJson(), 404, "Bah on demande pas du JSON ?");

        return $next($request);
    }
}
