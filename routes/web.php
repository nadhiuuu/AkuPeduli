<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\DonationController;

/*Halaman Utama & Auth*/
Route::get('/', [LandingController::class, 'index'])->name('home');

Route::prefix('auth/google')->group(function () {
    Route::get('/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('/callback', [GoogleAuthController::class, 'callback']);
});


/*Donasi (Campaign List & Detail)*/
Route::prefix('donasi')->name('donation.')->group(function () {

    Route::get('/', [DonationController::class, 'index'])->name('index');

    Route::get('/{campaign:slug}', [DonationController::class, 'show'])->name('detail');

    Route::get('/{campaign:slug}/bayar', [DonationController::class, 'donate'])->name('donate');

    Route::post('/{campaign:slug}/proses', [DonationController::class, 'process'])->name('process');
});


/*Galang Dana (Fundraising)*/
Route::prefix('galang-dana')->name('fundraising.')->group(function () {
    Route::get('/', function () {
        return view('pages.galang-donasi.index');
    })->name('index');

    Route::get('/agreement', function () {
        return view('components.persetujuan-modal');
    })->name('agreement');

    Route::get('/create', function () {
        return view('pages.galang-donasi.form-galang-donasi');
    })->name('create');

    Route::get('/verification', function () {
        return view('pages.galang-donasi.form-verifikasi');
    })->name('verification');
});


/*Dokumentasi Penyaluran Dana*/
Route::prefix('dokumentasi')->name('documentation.')->group(function () {
    Route::get('/', function () {
        return view('pages.dokumentasi.index');
    })->name('index');

    Route::get('/detail', function () {
        return view('pages.dokumentasi.detail-dokumentasi');
    })->name('detail');

    Route::get('/create', function () {
        return view('pages.dokumentasi.form-dokumentasi');
    })->name('create');
});


/*Tentang Kami (About)*/
Route::prefix('tentang')->name('tentang.')->group(function () {
    Route::get('/', function () {
        return view('pages.tentang.tentang-kami');
    })->name('index');

    Route::get('/faq', function () {
        return view('pages.tentang.faq');
    })->name('faq');

    Route::get('/syarat-ketentuan', function () {
        return view('pages.tentang.syarat-ketentuan');
    })->name('syarat-ketentuan');

    Route::get('/kebijakan-privasi', function () {
        return view('pages.tentang.kebijakan-privasi');
    })->name('kebijakan-privasi');

    Route::get('/hubungi-kami', function () {
        return view('pages.tentang.hubungi-kami');
    })->name('hubungi-kami');
});