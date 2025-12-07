<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Farm Manager Login Routes
Route::middleware('guest')->group(function () {
    Route::get('/farm/login', [AuthenticatedSessionController::class, 'create'])
        ->name('farm.login');
    
    Route::post('/farm/login', function () {
        return app(AuthenticatedSessionController::class)->store();
    });
});

// Farm Manager Protected Routes
Route::middleware(['auth', 'manager'])->prefix('farm')->name('farm.')->group(function () {
    Route::get('/dashboard', function () {
        return view('farm.dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

