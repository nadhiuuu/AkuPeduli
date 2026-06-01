<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;

class AboutController extends Controller
{
    private function getStatisticsData()
    {
        return [
            'totalDonations' => Donation::where('status', 'success')->sum('gross_amount'),
            'totalTransactions' => Donation::where('status', 'success')->count(),
            'totalUsers' => User::where('role', 'user')->count(),
            'totalCampaigns' => Campaign::count(),
        ];
    }

    public function index()
    {
        return view('pages.tentang.tentang-kami', $this->getStatisticsData());
    }

    public function faq()
    {
        return view('pages.tentang.faq', $this->getStatisticsData());
    }

    public function terms()
    {
        return view('pages.tentang.syarat-ketentuan', $this->getStatisticsData());
    }

    public function privacy()
    {
        return view('pages.tentang.kebijakan-privasi', $this->getStatisticsData());
    }

    public function contact()
    {
        return view('pages.tentang.hubungi-kami', $this->getStatisticsData());
    }
}
