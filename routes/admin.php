<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthenticationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LanguageController;

// Admin Login Routes (without middleware)
Route::group([
    'as' => 'admin.',
], function () {
    Route::get('/login', [AdminAuthenticationController::class, 'login'])->name('login');
    Route::post('/login', [AdminAuthenticationController::class, 'handleLogin'])->name('handle-login');

    // Password Reset Routes
    Route::get('/forgot-password', [AdminAuthenticationController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AdminAuthenticationController::class, 'sendResetLink'])->name('forget-password-send');
    Route::get('/password/reset/{token}', [AdminAuthenticationController::class, 'resetPassword'])->name('password.reset');
    Route::post('/password/reset', [AdminAuthenticationController::class, 'handleResetPassword'])->name('password.reset.send');
});

// Protected Admin Routes (with admin middleware)
Route::group([
    'as' => 'admin.',
    'middleware' => ['admin'],
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Language Management CRUD Routes
    Route::resource('language', LanguageController::class);
});
