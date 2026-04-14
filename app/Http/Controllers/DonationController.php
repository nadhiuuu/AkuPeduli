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
        // 1. Ambil semua nama kategori dari database untuk tombol filter
        $categories = DisasterCategory::pluck('name')->toArray();

        // 2. Ambil SEMUA campaign yang aktif
        $campaignData = Campaign::with(['impact', 'category'])
            ->withCount(['donations' => function ($query) {
                $query->where('status', 'success');
            }])
            ->where('status', 'aktif')
            ->latest() // Urutkan terbaru
            ->get()    // Hapus take(3) agar semua data terambil
            ->map(function ($campaign) {
                $target = $campaign->target_amount > 0 ? $campaign->target_amount : 1;
                $percentage = ($campaign->current_amount / $target) * 100;
                $daysLeft = Carbon::now()->startOfDay()->diffInDays(Carbon::parse($campaign->end_date)->startOfDay(), false);

                return [
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

        // 3. Kirim data campaign DAN data list kategori ke Blade
        return view('pages.donasi.index', [
            'campaigns' => $campaignData,
            'catList' => $categories
        ]);
    }
}
