<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Documentation;

class DocumentationController extends Controller
{
    public function show($slug)
    {
    $documentation = Documentation::with('campaign.user')
        ->where('slug', $slug)
        ->firstOrFail();

    return view('pages.dokumentasi.detail-dokumentasi', compact('documentation'));
    }

    public function index()
    {
    $documentations = Documentation::with('campaign.user')
        ->whereHas('campaign', function ($q) {
            $q->where('user_id', Auth::id());
        })
        ->latest()
        ->get();

    return view('pages.dokumentasi.index', compact('documentations'));
    }
}