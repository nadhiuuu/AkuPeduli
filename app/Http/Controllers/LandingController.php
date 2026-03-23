<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('pages.home.landing');
    }
}
