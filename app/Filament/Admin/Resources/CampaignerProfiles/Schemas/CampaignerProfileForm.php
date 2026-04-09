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
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('nik')
                    ->required(),
                TextInput::make('foto_ktp')
                    ->required(),
                Select::make('status_verifikasi')
                    ->options(['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'])
                    ->default('menunggu')
                    ->required(),
                Textarea::make('alasan_penolakan')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
