<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;

// Admin Login Routes
Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
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

// Admin Protected Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    
    // Password Update
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    
    // Districts Management
    Route::resource('districts', \App\Http\Controllers\Admin\DistrictController::class);
    
    // Farms Management
    Route::resource('farms', \App\Http\Controllers\Admin\FarmController::class);
    
    // Farm Managers Management
    Route::resource('managers', \App\Http\Controllers\Admin\ManagerController::class);
    Route::post('/managers/{manager}/reset-password', [\App\Http\Controllers\Admin\ManagerController::class, 'resetPassword'])
        ->name('managers.reset-password');
    
    // Entries Management
    Route::get('/entries', [\App\Http\Controllers\Admin\EntryController::class, 'index'])->name('entries.index');
    Route::get('/entries/{entry}', [\App\Http\Controllers\Admin\EntryController::class, 'show'])->name('entries.show');
});

