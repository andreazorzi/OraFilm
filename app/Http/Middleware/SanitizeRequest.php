<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SanitizeRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->merge($this->sanitize($request->all()));

        return $next($request);
    }
    
    private function sanitize($value) {
        if(is_array($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = $this->sanitize($val);
            }
            return $value;
        }
        else if ($value === '') {
            return null;
        }
        else if($value === 'true' || $value === 'false') {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        else if(is_numeric($value) && !Str::startsWith($value, '+')) {
            if (filter_var($value, FILTER_VALIDATE_INT) !== false) {
                return intval($value);
            } elseif (filter_var($value, FILTER_VALIDATE_FLOAT) !== false) {
                return floatval($value);
            }
        }
        
        return $value;
    }
}