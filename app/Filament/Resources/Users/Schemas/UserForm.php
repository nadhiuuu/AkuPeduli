<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('avatar')
                    ->label('Avatar')
                    ->image()
                    ->imageEditor()
                    ->directory('avatars')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif']),
                TextInput::make('name')
                    ->placeholder('Masukkan nama bawok kamu')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DatePicker::make('email_verified_at')
                    ->native(false)
                    ->label('Email Verified At')
                    ->placeholder('Pilih tanggal verifikasi email'),
                TextInput::make('bio')
                    ->label('Biography')
                    ->placeholder('Masukkan deskripsi spesifikasi bawok kamu')
                    ->maxLength(65535),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
