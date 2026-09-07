<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// ==========================================
// ROUTE UNTUK YANG BELUM LOGIN (guest)
// ==========================================
Route::middleware('guest')->group(function () {
    
    // Halaman Login
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    
    // Proses Login
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    
    // Halaman Register
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');
    
    // Proses Register
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// ==========================================
// ROUTE UNTUK YANG UDAH LOGIN (auth)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});