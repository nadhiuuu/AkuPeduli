<?php

namespace App\Filament\Admin\Widgets;

use App\Support\AdminDashboardAnalytics;
use Filament\Widgets\ChartWidget;

class DonationTrendChart extends ChartWidget
{
    protected int | string | array $columnSpan = 2;

    protected static ?int $sort = 2;

    protected ?string $heading = 'Grafik Donasi Harian 30 Hari';

    protected ?string $description = 'Nominal donasi sukses per hari';

    protected function getData(): array
    {
        $series = AdminDashboardAnalytics::donationSeries();

        return [
            'datasets' => [
                [
                    'label' => 'Donasi Sukses',
                    'data' => $series['data'],
                    'borderColor' => '#2563eb',
                    'backgroundColor' => 'rgba(37, 99, 235, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $series['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
