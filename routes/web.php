<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\HistoryDonationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
/*Halaman Utama & Auth*/
Route::get('/', [LandingController::class, 'index'])->name('home');

Route::prefix('auth/google')->group(function () {
    Route::get('/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('/callback', [GoogleAuthController::class, 'callback']);
});


/*Donasi (Campaign List & Detail)*/
Route::prefix('donasi')->name('donation.')->group(function () {

    Route::get('/', [DonationController::class, 'index'])->name('index');

    Route::get('/thanks', [DonationController::class, 'thanks'])->name('thanks');

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

    Route::get('/verification', \App\Livewire\CampaignerVerification::class)->middleware('auth')->name('verification');
});


/*Dokumentasi Penyaluran Dana*/
// Route::prefix('dokumentasi')->name('documentation.')->group(function () {
//     Route::get('/', function () {
//         return view('pages.dokumentasi.index');
//     })->name('index');

//     Route::get('/{slug}', [DocumentationController::class, 'show'])
//     ->name('detail');

//     Route::get('/create', function () {
//         return view('pages.dokumentasi.form-dokumentasi');
//     })->name('create');
// });
Route::prefix('dokumentasi')->name('documentation.')->group(function () {
    Route::get('/', [DocumentationController::class, 'index'])->name('index');

    Route::get('/{slug}', [DocumentationController::class, 'show'])->name('detail');

    Route::get('/create', function () {
        return view('pages.dokumentasi.form-dokumentasi');
    })->name('create');
});


/*Tentang Kami (About)*/
Route::prefix('tentang')->name('tentang.')->group(function () {
    Route::get('/', [AboutController::class, 'index'])->name('index');

    Route::get('/faq', [AboutController::class, 'faq'])->name('faq');

    Route::get('/syarat-ketentuan', [AboutController::class, 'terms'])->name('syarat-ketentuan');

    Route::get('/kebijakan-privasi', [AboutController::class, 'privacy'])->name('kebijakan-privasi');

    Route::get('/hubungi-kami', [AboutController::class, 'contact'])->name('hubungi-kami');
});

/*Profil Pengguna*/
Route::prefix('profil')
    ->middleware('auth')
    ->name('profil.')
    ->group(function () {

        Route::get('/', [HistoryDonationController::class, 'index'])->name('index');

});

Route::put('/profil/password', [ProfileController::class, 'updatePassword'])
    ->name('profile.password.update');