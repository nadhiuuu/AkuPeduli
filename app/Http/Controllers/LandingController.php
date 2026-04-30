<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Documentation;
use App\Models\Donation;
use App\Models\User;
use App\Support\CampaignMapData;

class LandingController extends Controller
{
    public function index()
    {
        $publicCampaigns = Campaign::with(['impact', 'category'])
            ->withCount(['donations' => function ($query) {
                $query->where('status', 'success');
            }])
            ->publiclyVisible()
            ->latest()
            ->get();

        $documentations = Documentation::with('campaign.user')
            ->latest()
            ->take(3)
            ->get();

        return view('pages.home.landing', [
            'campaigns' => CampaignMapData::cards($publicCampaigns, 3),
            'mapCampaigns' => CampaignMapData::mapCampaigns($publicCampaigns),
            'mapRegions' => CampaignMapData::regionSummaries($publicCampaigns),
            'documentations' => $documentations,
            'totalDonations' => Donation::where('status', 'success')->sum('gross_amount'),
            'totalTransactions' => Donation::where('status', 'success')->count(),
            'totalUsers' => User::where('role', 'user')->count(),
            'totalCampaigns' => Campaign::count(),
        ]);
    }
}
