<?php

namespace App\Filament\Admin\Widgets;

use App\Support\AdminDashboardAnalytics;
use Filament\Widgets\ChartWidget;

class DonationStatusChart extends ChartWidget
{
    protected int | string | array $columnSpan = 2;

    protected static ?int $sort = 3;

    protected ?string $heading = 'Distribusi Status Donasi';

    protected ?string $description = '30 hari terakhir';

    protected function getData(): array
    {
        $distribution = AdminDashboardAnalytics::donationStatusDistribution();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => [
                        $distribution['success'],
                        $distribution['pending'],
                        $distribution['failed'],
                    ],
                    'backgroundColor' => ['#16a34a', '#f59e0b', '#ef4444'],
                ],
            ],
            'labels' => ['Sukses', 'Pending', 'Gagal/Cancel'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
