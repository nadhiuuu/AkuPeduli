<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\DonationAnalyticsOverview;
use App\Filament\Admin\Widgets\DonationStatusChart;
use App\Filament\Admin\Widgets\DonationTrendChart;
use App\Filament\Admin\Widgets\DormantActiveCampaignsTable;
use App\Filament\Admin\Widgets\PendingCampaignReviewsOverview;
use App\Filament\Admin\Widgets\TopCampaignsByDonorsTable;
use App\Filament\Admin\Widgets\TopCampaignsByRaisedTable;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationLabel = 'Dashboard';

    protected ?string $heading = 'Dashboard AkuPeduli';

    public function getColumns(): int | array
    {
        return [
            'md' => 2,
            'xl' => 4,
        ];
    }

    public function getWidgets(): array
    {
        return [
            DonationAnalyticsOverview::class,
            DonationTrendChart::class,
            DonationStatusChart::class,
            TopCampaignsByRaisedTable::class,
            TopCampaignsByDonorsTable::class,
            DormantActiveCampaignsTable::class,
            PendingCampaignReviewsOverview::class,
        ];
    }
}
