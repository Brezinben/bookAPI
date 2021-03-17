<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAPI
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
    return  $request->user()->tokenCan('server:delete');
    }
}
