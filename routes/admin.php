<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthenticationController;
use App\Http\Controllers\Admin\DashboardController;

// Admin Login Routes (without middleware)
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {
    Route::get('/login', [AdminAuthenticationController::class, 'login'])->name('login');
});

// Protected Admin Routes (with admin middleware)
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['admin'],
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
