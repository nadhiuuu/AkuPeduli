<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\GoogleAuthController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// donasi
Route::get('/donasi', function () {
    return view('pages.donasi.index');
})->name('donasi');

Route::get('/donasi/detail', function () {
    return view('pages.donasi.detail-campaign');
})->name('donasi.detail-campaign');

Route::get('/donasi/berdonasi', function () {
    return view('pages.donasi.form-donasi');
})->name('donasi.berdonasi');

// galang donasi
Route::get('/galang-donasi', function () {
    return view('pages.galang-donasi.index');
})->name('galang-donasi');

Route::get('/galang-donasi/persetujuan', function () {
    return view('pages.components.persetujuan-modal');
})->name('galang-donasi.persetujuan');

Route::get('/galang-donasi/buat-galang-donasi', function () {
    return view('pages.galang-donasi.form-galang-donasi');
})->name('galang-donasi.buat-galang-donasi');

Route::get('/galang-donasi/form-verifikasi', function () {
    return view('pages.galang-donasi.form-verifikasi');
})->name('galang-donasi.form-verifikasi');

// dokumentasi
Route::get('/dokumentasi', function () {
    return view('pages.dokumentasi.index');
})->name('dokumentasi');

Route::get('/dokumentasi/detail-dokumentasi', function () {
    return view('pages.dokumentasi.detail-dokumentasi');
})->name('dokumentasi.detail-dokumentasi');

Route::get('/dokumentasi/buat-dokumentasi', function () {
    return view('pages.dokumentasi.form-dokumentasi');
})->name('dokumentasi.buat-dokumentasi');