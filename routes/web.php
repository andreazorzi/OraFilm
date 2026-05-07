<?php

use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Route;

// Backoffice
Route::prefix('backoffice')->group(function () {
    Route::get('/', [RouteController::class, 'backoffice_index'])->name('backoffice.index');
    
    Route::middleware(['auth'])->group(function () {
        Route::middleware(['groups:'.config('auth.administrators')])->group(function () {
            Route::view('users', 'backoffice.users', headers: ['menu' => true, /*'menu-group' => 'group'*/])->name('backoffice.users');
            // End Models Routes
        });
        
        Route::middleware(['groups:WebDev'])->group(function () {
            Route::view('logs', 'backoffice.logs', headers: ['menu' => true, 'weight' => 10])->name('backoffice.logs');
        });
    });
});

// Frontend translated routes
Route::group(['middleware' => 'locale'], function() {
    RouteController::translated_routes();
});

Route::middleware(['development'])->group(function(){
    Route::get('test', function(){
        return Illuminate\Foundation\Inspiring::quote();
    });
});