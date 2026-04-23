<?php

namespace App\Http\Controllers;

use App\Models\Documentation;

class DocumentationController extends Controller
{
    public function show($slug)
    {
    $documentation = Documentation::with('campaign')
        ->where('slug', $slug)
        ->firstOrFail();

    return view('pages.dokumentasi.detail-dokumentasi', compact('documentation'));
    }

    public function index()
    {
    $documentations = Documentation::with('campaign')
        ->latest()
        ->get();

    return view('pages.dokumentasi.index', compact('documentations'));
    }
}