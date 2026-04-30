<?php

namespace App\Support;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CampaignMapData
{
    public static function cards(Collection $campaigns, ?int $limit = null): array
    {
        $items = $limit ? $campaigns->take($limit) : $campaigns;

        return $items
            ->map(fn (Campaign $campaign): array => static::card($campaign))
            ->values()
            ->all();
    }

    public static function mapCampaigns(Collection $campaigns): array
    {
        return $campaigns
            ->map(function (Campaign $campaign): array {
                $impact = $campaign->impact;
                $status = $impact?->tingkat_keparahan ?? DisasterSeverityResolver::LOCAL;

                return [
                    'title' => $campaign->title,
                    'slug' => $campaign->slug,
                    'url' => route('donation.detail', $campaign->slug),
                    'category' => $campaign->category->name ?? 'Umum',
                    'lat' => $impact?->latitude,
                    'lng' => $impact?->longitude,
                    'kecamatan' => $impact?->kecamatan,
                    'desa' => $impact?->desa,
                    'raised' => (int) $campaign->current_amount,
                    'severity' => $status,
                    'severity_label' => DisasterSeverityResolver::labelFor($status),
                    'severity_color' => DisasterSeverityResolver::colorFor($status),
                    'severity_rank' => DisasterSeverityResolver::rankFor($status),
                ];
            })
            ->filter(fn (array $item): bool => filled($item['kecamatan']))
            ->values()
            ->all();
    }

    public static function regionSummaries(Collection $campaigns): array
    {
        return $campaigns
            ->filter(fn (Campaign $campaign): bool => filled($campaign->impact?->kecamatan))
            ->groupBy(fn (Campaign $campaign): string => JemberRegion::normalizeDistrictName($campaign->impact?->kecamatan))
            ->map(function (Collection $districtCampaigns): array {
                $dominant = $districtCampaigns
                    ->sortByDesc(fn (Campaign $campaign): int => DisasterSeverityResolver::rankFor($campaign->impact?->tingkat_keparahan))
                    ->first();

                $status = $dominant?->impact?->tingkat_keparahan ?? DisasterSeverityResolver::LOCAL;

                return [
                    'kecamatan' => $dominant?->impact?->kecamatan,
                    'severity' => $status,
                    'severity_label' => DisasterSeverityResolver::labelFor($status),
                    'severity_color' => DisasterSeverityResolver::colorFor($status),
                    'severity_rank' => DisasterSeverityResolver::rankFor($status),
                    'campaign_count' => $districtCampaigns->count(),
                    'campaign_titles' => $districtCampaigns->pluck('title')->filter()->values()->all(),
                ];
            })
            ->all();
    }

    private static function card(Campaign $campaign): array
    {
        $target = $campaign->target_amount > 0 ? $campaign->target_amount : 1;
        $percentage = ($campaign->current_amount / $target) * 100;
        $daysLeft = now()->startOfDay()->diffInDays(Carbon::parse($campaign->end_date)->startOfDay(), false);
        $impact = $campaign->impact;
        $status = $impact?->tingkat_keparahan ?? DisasterSeverityResolver::LOCAL;

        return [
            'slug' => $campaign->slug,
            'category' => $campaign->category->name ?? 'Umum',
            'title' => $campaign->title,
            'description' => Str::limit(strip_tags($campaign->description), 100),
            'raised' => (int) $campaign->current_amount,
            'goal' => (int) $campaign->target_amount,
            'percentage' => min(100, $percentage),
            'image' => asset('storage/'.$campaign->image),
            'lat' => $impact?->latitude ?? '-8.1724',
            'lng' => $impact?->longitude ?? '113.7003',
            'kecamatan' => $impact?->kecamatan,
            'severity' => $status,
            'severity_label' => DisasterSeverityResolver::labelFor($status),
            'severity_color' => DisasterSeverityResolver::colorFor($status),
            'donors_count' => $campaign->donations_count ?? 0,
            'days_left' => max(0, (int) $daysLeft),
        ];
    }
}
