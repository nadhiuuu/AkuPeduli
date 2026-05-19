<?php

namespace App\Filament\Admin\Resources\BankAccounts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BankAccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Rekening Aktif')
                    ->description('Rekening ini akan dipakai untuk pengajuan pencairan baru. Perubahan tidak mengubah histori pencairan yang sudah ada.')
                    ->columns(2)
                    ->schema([
                        Select::make('nama_bank')
                            ->label('Nama Bank')
                            ->options([
                                'BCA' => 'BCA',
                                'BNI' => 'BNI',
                                'BRI' => 'BRI',
                                'BSI' => 'BSI',
                                'BTN' => 'BTN',
                                'CIMB NIAGA' => 'CIMB Niaga',
                                'MANDIRI' => 'Mandiri',
                                'PERMATA' => 'Permata',
                            ])
                            ->searchable()
                            ->required(),
                        TextInput::make('nomor_rekening')
                            ->label('Nomor Rekening')
                            ->required()
                            ->numeric()
                            ->maxLength(30),
                        TextInput::make('nama_pemilik')
                            ->label('Nama Pemilik Rekening')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
