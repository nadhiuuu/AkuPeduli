<?php

namespace App\Filament\Admin\Resources\Campaigns\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Galang Dana')
                    ->required()
                    ->minLength(10) // Minimal 10 huruf
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->disabled()
                    ->dehydrated(),

                Select::make('category_id')
                    ->label('Kategori Bencana')
                    ->relationship('category', 'name') 
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('user_id')
                    ->label('Dibuat Oleh (User/Admin)')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->default(fn () => Auth::id())
                    ->required(),

                TextInput::make('target_amount')
                    ->label('Target Donasi')
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(100000) // Minimal target adalah 100 ribu
                    ->helperText('Minimal target donasi adalah Rp 100.000')
                    ->required(),

                TextInput::make('current_amount')
                    ->label('Terkumpul Saat Ini')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0) // Default 0 saat pertama kali dibuat
                    ->disabled() // Tidak bisa diubah manual agar aman
                    ->dehydrated() // Tetap disimpan ke database
                    ->helperText('Otomatis bertambah saat ada donasi berhasil.'),

                DatePicker::make('end_date')
                    ->label('Batas Waktu')
                    ->minDate(now()) // Cegah pemilihan tanggal di masa lalu
                    ->required(),

                Select::make('status')
                    ->label('Status Galang Dana')
                    ->options([
                        'aktif' => 'Aktif (Berjalan)',
                        'nonaktif' => 'Nonaktif (Menunggu/Ditutup)',
                        'selesai' => 'Selesai (Target Tercapai)',
                    ])
                    ->default('aktif')
                    ->required(),

                FileUpload::make('image')
                    ->label('Banner Galang Dana')
                    ->image()
                    ->disk('public')
                    ->directory('campaigns')
                    ->preserveFilenames()
                    ->columnSpanFull()
                    ->maxSize(5120),

                RichEditor::make('description')
                    ->label('Cerita / Deskripsi Bencana')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}