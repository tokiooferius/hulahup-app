<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

// 1. Halaman Awal
Route::get('/', function () {
    return view('auth.login'); // Mencari di views/auth/login.blade.php
});

// 2. Halaman Sign Up
Route::get('/signup', function () {
    return view('auth.signup'); // Mengarah ke folder auth
});

// Halaman Utama setelah Login
Route::get('/home', function () {
    return view('home'); // Langsung di folder views (bukan di dalam auth)
})->middleware('auth');

// 3. Proses Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'store']);
Route::get('/logout', [AuthController::class, 'logout']);

// 4. Halaman Keranjang
Route::get('/cart', function () {
    return view('cart'); 
})->middleware('auth');

// 5. Halaman Riwayat dan Topup
Route::get('/history', function () {
    return view('history');
})->middleware('auth');

Route::get('/topup', function () {
    return view('topup');
})->middleware('auth');

