<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\GoogleAuthController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
