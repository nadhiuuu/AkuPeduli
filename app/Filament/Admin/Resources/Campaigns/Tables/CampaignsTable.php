<?php

namespace App\Filament\Admin\Resources\Campaigns\Tables;

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
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', Auth::id()))
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

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'nonaktif' => 'danger',
                        'selesai' => 'info',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Filter Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Nonaktif',
                        'selesai' => 'Selesai',
                    ]),
            ])
            ->recordActions([
                Action::make('Lihat Web')
                    ->icon('heroicon-o-globe-alt')
                    ->color('info')
                    ->url(fn ($record): string => url('/campaign/' . $record->slug))
                    ->openUrlInNewTab(), // Buka di tab baru

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}