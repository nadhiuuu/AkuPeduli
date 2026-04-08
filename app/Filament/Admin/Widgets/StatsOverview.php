<?php

namespace App\Filament\Admin\Widgets; // Sesuaikan namespace jika berbeda

use App\Models\User;
use App\Models\Campaign;
use App\Models\Donation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Menghitung total uang dari donasi yang HANYA berstatus 'success'
        $totalUang = Donation::where('status', 'success')->sum('gross_amount');

        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Semua user terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Galang Dana', Campaign::count())
                ->description('Campaign di sistem')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('info'),

            Stat::make('Total Dana Terkumpul', 'Rp ' . number_format($totalUang, 0, ',', '.'))
                ->description('Dari donasi yang berhasil')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Grafik kecil pemanis (opsional)
        ];
    }
}