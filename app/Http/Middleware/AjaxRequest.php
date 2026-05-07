<?php 

namespace App\Http\Middleware;

class AjaxRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->ajax()){
            return $next($request);
        }

        return abort(403);
    }
}