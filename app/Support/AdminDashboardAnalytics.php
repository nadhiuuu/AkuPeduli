<?php

namespace App\Support;

use App\Models\Campaign;
use App\Models\CampaignerProfile;
use App\Models\Donation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminDashboardAnalytics
{
    public static function rangeStart(int $days = 30): Carbon
    {
        return now()->startOfDay()->subDays($days - 1);
    }

    public static function rangeEnd(): Carbon
    {
        return now()->endOfDay();
    }

    public static function previousRangeStart(int $days = 30): Carbon
    {
        return static::rangeStart($days)->copy()->subDays($days);
    }

    public static function previousRangeEnd(int $days = 30): Carbon
    {
        return static::rangeStart($days)->copy()->subSecond();
    }

    public static function totals(int $days = 30): array
    {
        $user = Auth::user();
        $start = static::rangeStart($days);
        $end = static::rangeEnd();
        $previousStart = static::previousRangeStart($days);
        $previousEnd = static::previousRangeEnd($days);

        $successStatuses = ['success'];
        $failedStatuses = ['failed', 'cancel', 'expire', 'deny'];

        $currentSuccessTotal = static::donationQuery($start, $end)
            ->whereIn('status', $successStatuses)
            ->sum('gross_amount');

        $previousSuccessTotal = static::donationQuery($previousStart, $previousEnd)
            ->whereIn('status', $successStatuses)
            ->sum('gross_amount');

        $currentSuccessCount = static::donationQuery($start, $end)
            ->whereIn('status', $successStatuses)
            ->count();

        $previousSuccessCount = static::donationQuery($previousStart, $previousEnd)
            ->whereIn('status', $successStatuses)
            ->count();

        return [
            'total_success_amount' => (int) $currentSuccessTotal,
            'total_success_amount_delta' => static::delta($currentSuccessTotal, $previousSuccessTotal),
            'success_transactions' => $currentSuccessCount,
            'success_transactions_delta' => static::delta($currentSuccessCount, $previousSuccessCount),
            'pending_transactions' => static::donationQuery($start, $end)->where('status', 'pending')->count(),
            'failed_transactions' => static::donationQuery($start, $end)->whereIn('status', $failedStatuses)->count(),
            'active_campaigns' => Campaign::query()->where('status', Campaign::STATUS_ACTIVE)->where('user_id', auth()->id())->count(),
            'ending_soon_campaigns' => Campaign::query()
                ->where('status', Campaign::STATUS_ACTIVE)
                ->where('user_id', auth()->id())
                ->whereDate('end_date', '>=', now()->toDateString())
                ->whereDate('end_date', '<=', now()->addDays(7)->toDateString())
                ->count(),
        ];
    }

    public static function donationSeries(int $days = 30): array
    {
        $start = static::rangeStart($days);
        $end = static::rangeEnd();
$query = Donation::query()
    ->selectRaw('DATE(created_at) as donation_date, SUM(gross_amount) as total')
    ->where('status', 'success')
    ->whereBetween('created_at', [$start, $end]);

    if (!auth()->user()?->isAdmin()) {

        $query->whereHas('campaign', function ($q) {
            $q->where('user_id', auth()->id());
        });

}
        $rows = $query->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'donation_date');

        $labels = [];
        $data = [];

        foreach (CarbonPeriod::create($start, '1 day', $end->copy()->startOfDay()) as $date) {
            $labels[] = $date->format('d M');
            $data[] = (int) ($rows[$date->toDateString()] ?? 0);
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public static function donationStatusDistribution(int $days = 30): array
    {
        $rows = static::donationQuery(static::rangeStart($days), static::rangeEnd())
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'success' => (int) ($rows['success'] ?? 0),
            'pending' => (int) ($rows['pending'] ?? 0),
            'failed' => (int) (($rows['failed'] ?? 0) + ($rows['cancel'] ?? 0) + ($rows['expire'] ?? 0) + ($rows['deny'] ?? 0)),
        ];
    }

        public static function topCampaignsByRaised(int $limit = 5): Collection
    {
        $query = Campaign::query()
            ->with(['impact'])
            ->withCount([
                'donations as successful_donations_count' => fn (Builder $query)
                    => $query->where('status', 'success')
            ])
            ->where('status', Campaign::STATUS_ACTIVE);

        // kalau bukan admin
        if (!auth()->user()?->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        return $query
            ->orderByDesc('current_amount')
            ->orderByDesc('successful_donations_count')
            ->limit($limit)
            ->get();
    }

    public static function topCampaignsByDonationCount(int $limit = 5): Collection
{
    $query = Campaign::query()
        ->with(['impact'])
        ->withCount([
            'donations as successful_donations_count' => fn (Builder $query)
                => $query->where('status', 'success')
        ])
        ->where('status', Campaign::STATUS_ACTIVE);

    if (!auth()->user()?->isAdmin()) {
        $query->where('user_id', auth()->id());
    }

    return $query
        ->orderByDesc('successful_donations_count')
        ->orderByDesc('current_amount')
        ->limit($limit)
        ->get();
}

    public static function activeCampaignsWithoutRecentDonations(int $days = 7, int $limit = 5): Collection
{
    $since = now()->subDays($days);

    $query = Campaign::query()
        ->with(['impact'])
        ->withCount([
            'donations as successful_donations_count' => fn (Builder $query)
                => $query->where('status', 'success')
        ])
        ->where('status', Campaign::STATUS_ACTIVE);

    if (!auth()->user()?->isAdmin()) {
        $query->where('user_id', auth()->id());
    }

    return $query
        ->whereDoesntHave('donations', fn (Builder $query)
            => $query
                ->where('status', 'success')
                ->where('created_at', '>=', $since))
        ->orderBy('end_date')
        ->limit($limit)
        ->get();
}

    public static function severitySummary(): array
    {
        $activeCampaigns = Campaign::query()
            ->with('impact')
            ->where('status', Campaign::STATUS_ACTIVE)
            ->where('user_id', auth()->id())
            ->get();

        $severityCounts = [
            DisasterSeverityResolver::LOCAL => 0,
            DisasterSeverityResolver::SIAGA => 0,
            DisasterSeverityResolver::MENENGAH => 0,
            DisasterSeverityResolver::KRITIS => 0,
        ];

        foreach ($activeCampaigns as $campaign) {
            $status = $campaign->impact?->tingkat_keparahan ?? DisasterSeverityResolver::LOCAL;
            $severityCounts[$status] = ($severityCounts[$status] ?? 0) + 1;
        }

        $districts = $activeCampaigns
            ->filter(fn (Campaign $campaign): bool => filled($campaign->impact?->kecamatan))
            ->groupBy(fn (Campaign $campaign): string => JemberRegion::normalizeDistrictName($campaign->impact?->kecamatan))
            ->map(function (Collection $campaigns): array {
                $dominant = $campaigns
                    ->sortByDesc(fn (Campaign $campaign): int => DisasterSeverityResolver::rankFor($campaign->impact?->tingkat_keparahan))
                    ->first();

                $status = $dominant?->impact?->tingkat_keparahan ?? DisasterSeverityResolver::LOCAL;

                return [
                    'kecamatan' => $dominant?->impact?->kecamatan,
                    'campaign_count' => $campaigns->count(),
                    'dominant_severity' => $status,
                ];
            })
            ->values();

        return [
            'counts' => $severityCounts,
            'top_districts' => $districts
                ->sortByDesc('campaign_count')
                ->take(5)
                ->values(),
            'critical_dominant_districts' => $districts
                ->filter(fn (array $district): bool => $district['dominant_severity'] === DisasterSeverityResolver::KRITIS)
                ->count(),
        ];
    }

    public static function quickActionCounts(): array
    {
        return [
            'pending_campaign_reviews' => Campaign::query()->where('user_id', auth()->id())->where('status', Campaign::STATUS_PENDING)->count(),
            'pending_campaigner_profiles' => CampaignerProfile::query()->where('user_id', auth()->id())->where('status_verifikasi', 'menunggu')->count(),
            'pending_donations' => Donation::query()->where('user_id', auth()->id())->where('status', 'pending')->count(),
        ];
    }

    private static function donationQuery(Carbon $start, Carbon $end): Builder
{
    $query = Donation::query()
        ->whereBetween('created_at', [$start, $end]);

    // kalau bukan admin
    if (!auth()->user()?->isAdmin()) {

        $query->whereHas('campaign', function ($q) {
            $q->where('user_id', auth()->id());
        });

    }

    return $query;
}
    private static function delta(int|float $current, int|float $previous): float
    {
        if ((float) $previous === 0.0) {
            return (float) ($current > 0 ? 100 : 0);
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
