<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAPI
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
        abort_if(!($request->user()->tokenCan('delete')), 401, "Bah on est pas Admin ?");
        return $next($request);
    }
}
