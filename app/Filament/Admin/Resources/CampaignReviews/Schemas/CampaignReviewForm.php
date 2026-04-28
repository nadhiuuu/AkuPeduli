<?php

namespace App\Filament\Admin\Resources\CampaignReviews\Schemas;

use App\Models\Campaign;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CampaignReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Ringkasan Campaign')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul Campaign')
                                ->disabled(),
                            Placeholder::make('campaigner_name')
                                ->label('Pengaju')
                                ->content(fn (?Campaign $record): string => $record?->user?->name ?? '-'),
                            Select::make('category_id')
                                ->label('Kategori Bencana')
                                ->relationship('category', 'name')
                                ->disabled()
                                ->dehydrated(false),
                            DatePicker::make('end_date')
                                ->label('Batas Waktu')
                                ->disabled()
                                ->dehydrated(false),
                            TextInput::make('target_amount')
                                ->label('Target Donasi')
                                ->numeric()
                                ->prefix('Rp')
                                ->disabled(),
                            Select::make('status')
                                ->label('Status Review')
                                ->options(Campaign::statusOptions())
                                ->disabled()
                                ->dehydrated(false),
                        ]),
                    Textarea::make('description')
                        ->label('Deskripsi Campaign')
                        ->disabled()
                        ->dehydrated(false)
                        ->rows(8)
                        ->columnSpanFull(),
                ]),

            Section::make('Review Disaster Impact')
                ->relationship('impact')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('kecamatan')
                                ->label('Kecamatan')
                                ->required(),
                            TextInput::make('desa')
                                ->label('Desa / Kelurahan')
                                ->required(),
                            TextInput::make('latitude')
                                ->label('Latitude')
                                ->numeric()
                                ->required(),
                            TextInput::make('longitude')
                                ->label('Longitude')
                                ->numeric()
                                ->required(),
                            TextInput::make('jumlah_korban')
                                ->label('Jumlah Korban Jiwa')
                                ->numeric()
                                ->minValue(0)
                                ->required(),
                            TextInput::make('jumlah_pengungsi')
                                ->label('Jumlah Pengungsi')
                                ->numeric()
                                ->minValue(0)
                                ->required(),
                            TextInput::make('luas_wilayah_ha')
                                ->label('Luas Wilayah Terdampak (Ha)')
                                ->numeric()
                                ->minValue(0)
                                ->required(),
                            TextInput::make('kerugian_materil')
                                ->label('Kerugian Materil / Infrastruktur')
                                ->numeric()
                                ->prefix('Rp')
                                ->minValue(0)
                                ->required(),
                            Select::make('tingkat_keparahan')
                                ->label('Tingkat Keparahan AI')
                                ->options([
                                    'pending_ai' => 'Menunggu Hasil AI',
                                    '1 - sangat ringan' => '1 - Sangat Ringan',
                                    '2 - ringan' => '2 - Ringan',
                                    '3 - sedang' => '3 - Sedang',
                                    '4 - parah' => '4 - Parah',
                                    '5 - sangat parah' => '5 - Sangat Parah',
                                ])
                                ->disabled()
                                ->dehydrated(false),
                            FileUpload::make('bukti_surat_bpbd')
                                ->label('Surat Bukti BPBD')
                                ->disk('public')
                                ->directory('disaster-impacts/bpbd')
                                ->visibility('public')
                                ->openable()
                                ->downloadable()
                                ->disabled()
                                ->dehydrated(false)
                                ->helperText('Buka file ini untuk mencocokkan angka input user dengan surat asli.'),
                        ]),
                ]),

            Section::make('Keputusan Review')
                ->schema([
                    Placeholder::make('submitted_for_review_at')
                        ->label('Diajukan Untuk Review')
                        ->content(fn (?Campaign $record): string => $record?->submitted_for_review_at?->format('d M Y H:i') ?? '-'),
                    Placeholder::make('reviewed_at')
                        ->label('Terakhir Direview')
                        ->content(fn (?Campaign $record): string => $record?->reviewed_at?->format('d M Y H:i') ?? '-'),
                    Textarea::make('rejection_reason')
                        ->label('Alasan Penolakan')
                        ->rows(4)
                        ->placeholder('Isi bila campaign perlu ditolak atau perlu catatan untuk campaigner.'),
                ])
                ->columns(2),
        ]);
    }
}
