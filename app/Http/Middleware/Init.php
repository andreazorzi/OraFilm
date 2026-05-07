<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class Init
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
        if(is_null(Cache::get("migrate"))){
            try {
                DB::connection()->getPdo();
                Artisan::call('migrate --force');
                Cache::forever("migrate", true);
            } catch (\Exception $e) {}
        }
        
        // check if user admin exists
        // if (!is_null(config("auth.admin.username")) && is_null(User::find(config("auth.admin.username")))) {
        //     Artisan::call('db:seed --force');
        // }
        
        return $next($request);
    }
}