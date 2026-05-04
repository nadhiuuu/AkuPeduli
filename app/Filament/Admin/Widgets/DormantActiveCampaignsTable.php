<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Campaign;
use App\Support\AdminDashboardAnalytics;
use App\Support\DisasterSeverityResolver;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class DormantActiveCampaignsTable extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 6;

    protected function getTableHeading(): string
    {
        return 'Campaign Aktif Tanpa Donasi 7 Hari Terakhir';
    }

    public function table(Table $table): Table
    {
        $ids = AdminDashboardAnalytics::activeCampaignsWithoutRecentDonations()->pluck('id')->all();

        return $table
            ->query(
                Campaign::query()
                    ->with(['impact'])
                    ->whereIn('id', $ids)
                    ->orderBy('end_date')
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('title')
                    ->label('Campaign')
                    ->limit(32)
                    ->weight('bold'),
                TextColumn::make('impact.kecamatan')
                    ->label('Kecamatan')
                    ->default('-'),
                TextColumn::make('impact.tingkat_keparahan')
                    ->label('Severity')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => DisasterSeverityResolver::labelFor($state))
                    ->color(fn (?string $state): string => match ($state) {
                        DisasterSeverityResolver::SIAGA => 'warning',
                        DisasterSeverityResolver::MENENGAH => 'info',
                        DisasterSeverityResolver::KRITIS => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('current_amount')
                    ->label('Terkumpul')
                    ->money('IDR', locale: 'id'),
                TextColumn::make('end_date')
                    ->label('Berakhir')
                    ->date('d M Y'),
            ])
            ->recordActions([
                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn (Campaign $record): string => \App\Filament\Admin\Resources\Campaigns\CampaignResource::getUrl('edit', ['record' => $record])),
                Action::make('lihatWeb')
                    ->label('Web')
                    ->icon('heroicon-o-globe-alt')
                    ->openUrlInNewTab()
                    ->url(fn (Campaign $record): string => route('donation.detail', $record->slug)),
            ]);
    }
}
