<?php

use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans-callback', [DonationController::class, 'callback']);
