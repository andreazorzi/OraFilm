<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class BelongsToGroups
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$groups)
    {
        $user = User::current();
        
        if(!is_null($user) && $user->belongsToGroup($groups)){
            return $next($request);
        }
        else if($request->ajax()){
            abort(403, 'Unauthorized');
        }
        else if(is_null($user)){
            session([
                "website.redirect" => $request->url()
            ]);
        }
        
        return redirect()->route('backoffice.index');
    }
}