<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Documentation;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Tambahkan withCount untuk menghitung donasi yang 'success'
        $campaignData = Campaign::with('impact')
            ->withCount(['donations' => function ($query) {
                $query->where('status', 'success'); // Hanya hitung uang yang benar-benar masuk
            }])
            ->publiclyVisible()
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($campaign) {
                $target = $campaign->target_amount > 0 ? $campaign->target_amount : 1;
                $percentage = ($campaign->current_amount / $target) * 100;

                // Hitung sisa hari dari hari ini ke end_date
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
                    
                    // --- TAMBAHAN BARU ---
                    'donors_count' => $campaign->donations_count, // Hasil dari withCount di atas
                    'days_left' => max(0, intval($daysLeft)), // Cegah angka minus jika sudah lewat deadline
                ];
            });
            $documentations = Documentation::with('campaign.user')
            ->latest()
            ->take(3)
            ->get();

        return view('pages.home.landing', [
            'campaigns' => $campaignData,
            'documentations' => $documentations
        ]);
    }
}
