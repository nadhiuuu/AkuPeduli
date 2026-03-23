<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

// public landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// dashboard/home page (requires authentication)
Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');
