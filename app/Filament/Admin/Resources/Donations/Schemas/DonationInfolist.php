<?php

namespace App\Filament\Admin\Resources\Donations\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Schemas\Schema;

class DonationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Transaksi Donasi')
                    ->schema([
                        TextEntry::make('order_id')
                            ->label('Order ID')
                            ->copyable(), // Bisa disalin dengan sekali klik
                            
                        TextEntry::make('campaign.title')
                            ->label('Galang Dana Tujuan'),
                            
                        TextEntry::make('donor_name')
                            ->label('Nama Donatur'),
                            
                        IconEntry::make('is_anonymous')
                            ->label('Hamba Allah (Sembunyikan Nama)')
                            ->boolean(),
                            
                        TextEntry::make('gross_amount')
                            ->label('Jumlah Donasi')
                            ->money('IDR', locale: 'id') // Format Rp
                            ->color('success')
                            ->weight('bold'),
                            
                        TextEntry::make('payment_type')
                            ->label('Metode Pembayaran')
                            ->placeholder('Belum dipilih/diketahui'),
                            
                        TextEntry::make('status')
                            ->label('Status Transaksi')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'success' => 'success',
                                'pending' => 'warning',
                                'failed', 'expire', 'cancel' => 'danger',
                                default => 'gray',
                            }),
                            
                        TextEntry::make('created_at')
                            ->label('Waktu Donasi')
                            ->dateTime('d F Y H:i:s'),

                        TextEntry::make('message')
                            ->label('Pesan / Doa dari Donatur')
                            ->placeholder('Tidak ada pesan.')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }
}