<?php

namespace App\Filament\Admin\Widgets;

use App\Support\AdminDashboardAnalytics;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DonationAnalyticsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totals = AdminDashboardAnalytics::totals();
        $series = AdminDashboardAnalytics::donationSeries();
        $recentSparkline = array_slice($series['data'], -7);

        return [
            Stat::make('Total Donasi Masuk 30 Hari', 'Rp '.number_format($totals['total_success_amount'], 0, ',', '.'))
                ->description($this->deltaDescription($totals['total_success_amount_delta'], 'vs 30 hari sebelumnya'))
                ->descriptionIcon($totals['total_success_amount_delta'] >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($totals['total_success_amount_delta'] >= 0 ? 'success' : 'danger')
                ->chart($recentSparkline),

            Stat::make('Transaksi Sukses 30 Hari', number_format($totals['success_transactions'], 0, ',', '.'))
                ->description($this->deltaDescription($totals['success_transactions_delta'], 'vs 30 hari sebelumnya'))
                ->descriptionIcon($totals['success_transactions_delta'] >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($totals['success_transactions_delta'] >= 0 ? 'success' : 'danger')
                ->chart($recentSparkline),

            Stat::make('Transaksi Pending 30 Hari', number_format($totals['pending_transactions'], 0, ',', '.'))
                ->description('Perlu dipantau admin')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Transaksi Gagal/Cancel 30 Hari', number_format($totals['failed_transactions'], 0, ',', '.'))
                ->description('Status gagal, cancel, expire, deny')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Campaign Aktif', number_format($totals['active_campaigns'], 0, ',', '.'))
                ->description('Sedang tayang di publik')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('info'),

            Stat::make('Campaign Hampir Berakhir', number_format($totals['ending_soon_campaigns'], 0, ',', '.'))
                ->description('Berakhir dalam 7 hari')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color($totals['ending_soon_campaigns'] > 0 ? 'warning' : 'success'),
        ];
    }

    private function deltaDescription(float $delta, string $suffix): string
    {
        $sign = $delta > 0 ? '+' : '';

        return "{$sign}{$delta}% {$suffix}";
    }
}
