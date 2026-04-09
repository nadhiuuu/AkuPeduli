<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\GoogleAuthController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::get('/donasi', function () {
    return view('pages.donasi.index'); 
})->name('donasi');

Route::get('/donasi/detail', function () {
    return view('pages.donasi.detail-campaign');
})->name('donasi.detail-campaign');

Route::get('/donasi/berdonasi', function () {
    return view('pages.donasi.form-donasi');
})->name('donasi.berdonasi');