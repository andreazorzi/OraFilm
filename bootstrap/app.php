<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('auth')
                ->group(base_path('routes/auth.php'));
                
            Route::middleware(['web', 'ajax', 'sanitize_request'])
                ->prefix('requests')
                ->group(base_path('routes/requests.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Custom middleware
        $middleware->alias([
            'ajax' => App\Http\Middleware\AjaxRequest::class,
            'api-token' => App\Http\Middleware\ApiToken::class,
            'development' => App\Http\Middleware\DevelopmentEnviroment::class,
            'groups' => App\Http\Middleware\BelongsToGroups::class,
            'locale' => App\Http\Middleware\SetLocale::class,
            'sanitize_request' => App\Http\Middleware\SanitizeRequest::class,
            'users' => App\Http\Middleware\AuthUsers::class,
        ]);
        
        // Maintenance mode
        $middleware->use([
            PreventRequestsDuringMaintenance::class,
            App\Http\Middleware\Init::class
        ]);
        
        $middleware->api(append: [
            App\Http\Middleware\SanitizeRequest::class,
        ]);
        
        $middleware->redirectGuestsTo(function(){
            if(!Auth::check() && !request()->ajax()){
                session([
                    "website.redirect" => request()->url()
                ]);
            }
            return route('backoffice.index');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
