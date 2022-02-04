<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GlobalMiddlewareConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        view()->share('mdata', 'Data from middleware');
        return $next($request);
    }
}
