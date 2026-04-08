<?php

namespace App\Filament\Admin\Resources\Donations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DonationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id')
                    ->label('Order ID')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make('donor_name')
                    ->label('Donatur')
                    ->searchable()
                    ->description(fn ($record): string => $record->is_anonymous ? 'Hamba Allah (Anonim)' : ''),

                TextColumn::make('campaign.title')
                    ->label('Galang Dana')
                    ->searchable()
                    ->limit(25),

                TextColumn::make('gross_amount')
                    ->label('Jumlah')
                    ->money('IDR', locale: 'id')
                    ->color('success')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'pending' => 'warning',
                        'failed', 'expire', 'cancel' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // Otomatis yang paling baru ada di atas
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'success' => 'Berhasil (Success)',
                        'pending' => 'Menunggu (Pending)',
                        'failed' => 'Gagal/Batal (Failed)',
                    ]),
                SelectFilter::make('campaign_id')
                    ->label('Filter Galang Dana')
                    ->relationship('campaign', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(), // HANYA ada tombol View (Mata)
            ])
            ->toolbarActions([
                // Kosongkan agar tidak ada fitur hapus massal (DeleteBulkAction dihapus)
            ]);
    }
}