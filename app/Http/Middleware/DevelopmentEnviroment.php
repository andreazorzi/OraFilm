<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class DevelopmentEnviroment
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (App::environment('local')) {
            return $next($request);
        }

        return abort(404);
    }
}