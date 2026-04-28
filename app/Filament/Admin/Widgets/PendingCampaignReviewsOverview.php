<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\CampaignReviews\CampaignReviewResource;
use App\Models\Campaign;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PendingCampaignReviewsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    protected function getStats(): array
    {
        $pendingCount = Campaign::query()
            ->where('status', Campaign::STATUS_PENDING)
            ->count();

        return [
            Stat::make('Campaign Menunggu Verifikasi', $pendingCount)
                ->description('Klik untuk membuka antrean review admin')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color($pendingCount > 0 ? 'warning' : 'success')
                ->url(CampaignReviewResource::getUrl('index')),
        ];
    }
}
