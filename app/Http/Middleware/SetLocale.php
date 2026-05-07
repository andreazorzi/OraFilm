<?php

namespace App\Http\Middleware;

use App\Http\Controllers\RouteController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->language ?? $request->segment(1) ?? config('app.locale');

        if((strlen($lang) === 2 && in_array($lang, RouteController::languages()))){
            app()->setLocale($lang);
        }

        return $next($request);
    }
}
