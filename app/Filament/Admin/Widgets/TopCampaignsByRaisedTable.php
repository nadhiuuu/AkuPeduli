<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Campaign;
use App\Support\AdminDashboardAnalytics;
use App\Support\DisasterSeverityResolver;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class TopCampaignsByRaisedTable extends TableWidget
{
    protected int | string | array $columnSpan = 2;

    protected static ?int $sort = 4;

    protected function getTableHeading(): string
    {
        return 'Top 5 Campaign Berdasarkan Dana Terkumpul';
    }

    public function table(Table $table): Table
    {
        $ids = AdminDashboardAnalytics::topCampaignsByRaised()->pluck('id')->all();

        return $table
            ->query(
                Campaign::query()
                    ->with(['impact'])
                    ->withCount(['donations as successful_donations_count' => fn (Builder $query) => $query->where('status', 'success')])
                    ->whereIn('id', $ids)
                    ->orderByDesc('current_amount')
                    ->orderByDesc('successful_donations_count')
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('title')
                    ->label('Campaign')
                    ->limit(28)
                    ->weight('bold'),
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
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('successful_donations_count')
                    ->label('Donasi')
                    ->numeric()
                    ->sortable(),
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
