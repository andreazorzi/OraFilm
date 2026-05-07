<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\AuthentikController;

// Authentik
Route::prefix('authentik')->group(function () {
	Route::get('/login', [AuthentikController::class, 'submit'])->name('auth.authentik.login');
	Route::get('/logout', [AuthentikController::class, 'logout'])->name('auth.authentik.logout');
	Route::get('/callback', [AuthentikController::class, 'callback'])->name('auth.authentik.callback');
	Route::get('/user', [AuthentikController::class, 'userProfile'])->name('auth.authentik.user');
}); 

// Web Login
Route::prefix('web')->group(function () {
	Route::post('login', [WebAuthController::class, 'login'])->name('auth.web.login');
	Route::get('logout', [WebAuthController::class, 'logout'])->name('auth.web.logout');
	Route::get('reset-password/{reset_link}', [WebAuthController::class, 'reset_password'])->name('auth.web.reset-password');
}); 