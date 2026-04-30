<?php

namespace App\Filament\Admin\Resources\Campaigns\Tables;

use App\Models\Campaign;
use App\Support\DisasterSeverityResolver;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class CampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                $user = Auth::user();

                if (! $user || $user->isAdmin()) {
                    return $query;
                }

                return $query->where('user_id', $user->id);
            })
            ->columns([
                ImageColumn::make('image')
                    ->label('Banner')
                    ->disk('public')
                    ->square(),

                TextColumn::make('title')
                    ->label('Judul Galang Dana')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->weight('bold'),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Pembuat')
                    ->icon('heroicon-o-user')
                    ->sortable(),

                TextColumn::make('target_amount')
                    ->label('Target')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                TextColumn::make('current_amount')
                    ->label('Terkumpul')
                    ->money('IDR', locale: 'id')
                    ->color('success')
                    ->sortable(),

                TextColumn::make('impact.tingkat_keparahan')
                    ->label('Status Bencana')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => DisasterSeverityResolver::labelFor($state))
                    ->color(fn (?string $state): string => match ($state) {
                        DisasterSeverityResolver::SIAGA => 'warning',
                        DisasterSeverityResolver::MENENGAH => 'info',
                        DisasterSeverityResolver::KRITIS => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Campaign::STATUS_PENDING => 'warning',
                        Campaign::STATUS_ACTIVE => 'success',
                        Campaign::STATUS_REJECTED => 'danger',
                        Campaign::STATUS_COMPLETED => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => Campaign::statusOptions()[$state] ?? $state),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Filter Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(Campaign::statusOptions()),
            ])
            ->recordActions([
                Action::make('Lihat Web')
                    ->icon('heroicon-o-globe-alt')
                    ->color('info')
                    ->url(fn ($record): string => route('donation.detail', $record->slug))
                    ->visible(fn (Campaign $record): bool => $record->status === Campaign::STATUS_ACTIVE)
                    ->openUrlInNewTab(),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
