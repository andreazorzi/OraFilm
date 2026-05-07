<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
// End Controllers Imports

Route::prefix('backoffice')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::post('users/impersonate/stop', [UserController::class, 'stop_impersonate'])->name('users.impersonate.stop');
        
        Route::middleware(['groups:'.config("auth.administrators")])->group(function () {
            // Users
            Route::resource('users', UserController::class);
            Route::prefix('users/{user}')->group(function () {
                Route::post('impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
                Route::post('send-reset-password', [UserController::class, 'send_reset_password'])->name('users.send-reset-password');
            });
            
            // End Models Routes
        });
        
        Route::middleware(['groups:WebDev'])->group(function () {
            Route::delete('clear', [LogController::class, 'clear'])->name('logs.clear');
        });
    });
    
    Route::put('users/reset-password/{reset_link}', [UserController::class, 'change_password'])->name('user.change-password');
});

// // Frontend
// Route::group(['middleware' => 'locale'], function() {
    
// });

// Development
Route::middleware(['development'])->group(function(){
    
});