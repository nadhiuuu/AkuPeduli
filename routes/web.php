<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\GoogleAuthController;

Route::get('/', [LandingController::class, 'index'])->name('home');

// auth
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// donation (donasi)
Route::prefix('donation')->group(function () {
    Route::get('/', function () {
        return view('pages.donasi.index');
    })->name('donation.index');

    Route::get('/detail', function () {
        return view('pages.donasi.detail-campaign');
    })->name('donation.detail');

    Route::get('/donate', function () {
        return view('pages.donasi.form-donasi');
    })->name('donation.donate');
});

// fundraising (galang donasi)
Route::prefix('fundraising')->group(function () {
    Route::get('/', function () {
        return view('pages.galang-donasi.index');
    })->name('fundraising.index');

    Route::get('/agreement', function () {
        return view('pages.components.persetujuan-modal');
    })->name('fundraising.agreement');

    Route::get('/create', function () {
        return view('pages.galang-donasi.form-galang-donasi');
    })->name('fundraising.create');

    Route::get('/verification', function () {
        return view('pages.galang-donasi.form-verifikasi');
    })->name('fundraising.verification');
});

// documentation (dokumentasi)
Route::prefix('documentation')->group(function () {
    Route::get('/', function () {
        return view('pages.dokumentasi.index');
    })->name('documentation.index');

    Route::get('/detail', function () {
        return view('pages.dokumentasi.detail-dokumentasi');
    })->name('documentation.detail');

    Route::get('/create', function () {
        return view('pages.dokumentasi.form-dokumentasi');
    })->name('documentation.create');
});

// about
Route::get('/about', function () {
    return view('pages.tentang.tentang-kami');
})->name('about');