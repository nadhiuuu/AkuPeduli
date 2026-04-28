<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Donation;
use Illuminate\Http\Request;

class HistoryDonationController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();

    $perPage = $request->get('perPage', 10); // default 10

    $donations = Donation::with('campaign')
        ->where('user_id', $user->id)
        ->latest()
        ->paginate($perPage)
        ->withQueryString();

    $totalDonasi = Donation::where('user_id', $user->id)
        ->where('status', 'success')
        ->sum('gross_amount');

    $frekuensi = Donation::where('user_id', $user->id)
        ->where('status', 'success')
        ->count();

    return view('pages.profil.index', compact(
        'donations',
        'totalDonasi',
        'frekuensi'
    ));
}
}