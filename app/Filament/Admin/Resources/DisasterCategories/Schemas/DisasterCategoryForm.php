<?php

namespace App\Filament\Admin\Resources\DisasterCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DisasterCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->disabled()
                    ->dehydrated()
                    ->helperText('Slug akan otomatis terisi berdasarkan Nama Kategori.'),
                TextInput::make('icon')
                    ->label('Icon (Emoji)')
                    ->placeholder('Contoh: 🔥 atau 🌊')
                    ->helperText('Tekan tombol Windows + Titik (.) untuk memunculkan panel Emoji.')
                    ->maxLength(255),
            ]);
    }
}