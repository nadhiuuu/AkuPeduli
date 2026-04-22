<?php

namespace App\Filament\Admin\Resources\CampaignerProfiles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CampaignerProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Pengguna')
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->required(),
                        TextInput::make('no_wa')->disabled(),
                        TextInput::make('email_campaigner')->disabled(),
                    ]),
                \Filament\Schemas\Components\Section::make('Dokumen Identitas')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nik')->disabled()->required(),
                        \Filament\Forms\Components\FileUpload::make('foto_ktp')
                            ->image()
                            ->disabled()
                            ->directory('campaigner_docs'),
                        \Filament\Forms\Components\FileUpload::make('foto_selfie_ktp')
                            ->image()
                            ->disabled()
                            ->directory('campaigner_docs'),
                    ]),
                \Filament\Schemas\Components\Section::make('Status Verifikasi')
                    ->schema([
                        Select::make('status_verifikasi')
                            ->options(['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'])
                            ->required(),
                        Textarea::make('alasan_penolakan')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
