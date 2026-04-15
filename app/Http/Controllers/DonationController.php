<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\DisasterCategory;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function index()
    {
        $categories = DisasterCategory::pluck('name')->toArray();

        $campaignData = Campaign::with(['impact', 'category'])
            ->withCount(['donations' => function ($query) {
                $query->where('status', 'success');
            }])
            ->where('status', 'aktif')
            ->latest()
            ->get()
            ->map(function ($campaign) {
                $target = $campaign->target_amount > 0 ? $campaign->target_amount : 1;
                $percentage = ($campaign->current_amount / $target) * 100;
                $daysLeft = Carbon::now()->startOfDay()->diffInDays(Carbon::parse($campaign->end_date)->startOfDay(), false);

                return [
                    'slug' => $campaign->slug,
                    'category' => $campaign->category->name ?? 'Umum',
                    'title' => $campaign->title,
                    'description' => Str::limit(strip_tags($campaign->description), 100),
                    'raised' => $campaign->current_amount,
                    'goal' => $campaign->target_amount,
                    'percentage' => min(100, $percentage),
                    'image' => asset('storage/' . $campaign->image),
                    'lat' => $campaign->impact->latitude ?? '-8.1724',
                    'lng' => $campaign->impact->longitude ?? '113.7003',
                    'donors_count' => $campaign->donations_count,
                    'days_left' => max(0, intval($daysLeft)),
                ];
            });

        return view('pages.donasi.index', [
            'campaigns' => $campaignData,
            'catList' => $categories
        ]);
    }

    public function show(Campaign $campaign)
    {
        $campaign->load(['impact', 'category', 'user']);

        $donorsCount = $campaign->donations()->where('status', 'success')->count();

        $daysLeft = max(0, Carbon::now()->startOfDay()->diffInDays(Carbon::parse($campaign->end_date)->startOfDay(), false));

        $target = $campaign->target_amount > 0 ? $campaign->target_amount : 1;
        $percentage = min(100, ($campaign->current_amount / $target) * 100);

        return view('pages.donasi.detail-campaign', [
            'campaign' => $campaign,
            'donorsCount' => $donorsCount,
            'daysLeft' => $daysLeft,
            'percentage' => $percentage,
        ]);
    }

    public function donate(Campaign $campaign)
    {
        // Hitung sisa hari dan persentase untuk ringkasan di atas form
        $daysLeft = max(0, Carbon::now()->startOfDay()->diffInDays(Carbon::parse($campaign->end_date)->startOfDay(), false));
        $target = $campaign->target_amount > 0 ? $campaign->target_amount : 1;
        $percentage = min(100, ($campaign->current_amount / $target) * 100);

        return view('pages.donasi.form-donasi', [
            'campaign' => $campaign,
            'daysLeft' => $daysLeft,
            'percentage' => $percentage
        ]);
    }
}
