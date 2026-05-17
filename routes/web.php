<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// 1. Halaman LANDING PAGE (Welcome) - Ini pintu masuk utama
Route::get('/', function () {
    return view('welcome'); // Ini akan memanggil file welcome.blade.php yang ada logo Hulahup
});

// 2. Halaman Login
Route::get('/login', function () {
    return view('auth.login'); // Pastikan file ada di resources/views/auth/login.blade.php
})->name('login');

// 3. Halaman Sign Up
Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

// 4. Halaman Utama Dashboard (Setelah Login)
Route::get('/home', function () {
    return view('home'); 
})->middleware('auth');

// 5. Proses Logic Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/topup', [AuthController::class, 'topup'])->middleware('auth');

// 6. Profile Routes
Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->middleware('auth')->name('profile.upload-photo');

// 7. Halaman Lainnya
Route::get('/history', function () { return view('history'); })->middleware('auth');
Route::get('/topup', function () { return view('topup'); })->middleware('auth');

