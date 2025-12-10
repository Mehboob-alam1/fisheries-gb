<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;

// Farm Manager Login Routes
Route::middleware('guest')->prefix('farm')->name('farm.')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    
    // Password Reset Routes
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Farm Manager Protected Routes
Route::middleware(['auth', 'manager'])->prefix('farm')->name('farm.')->group(function () {
    Route::get('/dashboard', function () {
        return view('farm.dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    
    // Password Update
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    
    // Daily Entries Management
    Route::resource('entries', \App\Http\Controllers\Farm\EntryController::class);
    
    // Staff Management
    Route::resource('staff', \App\Http\Controllers\Farm\StaffController::class);
});

