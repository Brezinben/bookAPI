<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EditorAPI
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
        abort_if(!($request->user()->tokenCan('create') && $request->user()->tokenCan('update')), 401, "Bah on est pas Éditeur ?");
        return $next($request);
    }
}
