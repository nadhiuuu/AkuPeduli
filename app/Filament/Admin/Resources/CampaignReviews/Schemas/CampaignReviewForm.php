<?php

namespace App\Filament\Admin\Resources\CampaignReviews\Schemas;

use App\Models\Campaign;
use App\Support\DisasterSeverityResolver;
use App\Support\JemberRegion;
use App\Support\RupiahInput;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\Checkbox;
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
    private const REGION_SELECTION_ZOOM = 14;

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
                                ->prefix('Rp')
                                ->type('text')
                                ->inputMode('numeric')
                                ->afterStateHydrated(fn (TextInput $component, $state) => $component->rawState(RupiahInput::format($state)))
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
                ->mutateRelationshipDataBeforeFillUsing(fn (array $data): array => static::mutateImpactData($data))
                ->mutateRelationshipDataBeforeSaveUsing(fn (array $data): array => static::mutateImpactData($data))
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('kecamatan')
                                ->label('Kecamatan')
                                ->options(JemberRegion::districtOptions())
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(fn ($set) => $set('desa', null))
                                ->required(),
                            Select::make('desa')
                                ->label('Desa / Kelurahan')
                                ->options(fn ($get): array => JemberRegion::villagesForDistrict($get('kecamatan')))
                                ->searchable()
                                ->disabled(fn ($get): bool => blank($get('kecamatan')))
                                ->live()
                                ->afterStateHydrated(fn ($get, $set) => static::syncLocationFromRegionSelection($get, $set))
                                ->afterStateUpdated(fn (Select $component, $get, $set) => static::syncLocationFromRegionSelection($get, $set, $component))
                                ->required(),
                            Map::make('lokasi_map')
                                ->label('Pilih Titik Lokasi Peta')
                                ->columnSpanFull()
                                ->defaultLocation(-8.1724, 113.7000)
                                ->zoom(11)
                                ->clickable(true)
                                ->draggable(true)
                                ->live()
                                ->dehydrated(false)
                                ->afterStateHydrated(fn (Map $component, $get) => static::hydrateMapFromCoordinates($component, $get))
                                ->afterStateUpdated(function ($set, ?array $state): void {
                                    if ($state) {
                                        $set('latitude', $state['lat']);
                                        $set('longitude', $state['lng']);
                                    }
                                }),
                            TextInput::make('latitude')
                                ->label('Latitude')
                                ->numeric()
                                ->required(),
                            TextInput::make('longitude')
                                ->label('Longitude')
                                ->numeric()
                                ->required(),
                            TextInput::make('jumlah_korban')
                                ->label('Jumlah Meninggal')
                                ->numeric()
                                ->minValue(0)
                                ->required(),
                            TextInput::make('jumlah_terdampak')
                                ->label('Jumlah Terdampak')
                                ->numeric()
                                ->minValue(0)
                                ->required(),
                            TextInput::make('rumah_rusak')
                                ->label('Rumah Rusak')
                                ->numeric()
                                ->minValue(0)
                                ->required(),
                            Checkbox::make('fasilitas_vital_lumpuh')
                                ->label('Fasilitas Vital Lumpuh'),
                            TextInput::make('kerugian_materil')
                                ->label('Kerugian Materil / Infrastruktur')
                                ->prefix('Rp')
                                ->type('text')
                                ->inputMode('numeric')
                                ->live()
                                ->afterStateHydrated(fn (TextInput $component, $state) => $component->rawState(RupiahInput::format($state)))
                                ->afterStateUpdated(fn (TextInput $component, $state) => $component->rawState(RupiahInput::format($state)))
                                ->mutateStateForValidationUsing(fn ($state) => RupiahInput::normalize($state))
                                ->dehydrateStateUsing(fn ($state) => RupiahInput::normalize($state))
                                ->rule('integer')
                                ->minValue(0)
                                ->required(),
                            Select::make('tingkat_keparahan')
                                ->label('Status Bencana Otomatis')
                                ->options(DisasterSeverityResolver::options())
                                ->disabled()
                                ->dehydrated()
                                ->helperText('Nilai ini dihitung otomatis dari data review admin.'),
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
                            Placeholder::make('severity_summary')
                                ->label('Ringkasan Status')
                                ->content(fn ($get): string => static::severitySummary($get))
                                ->columnSpanFull(),
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

    private static function mutateImpactData(array $data): array
    {
        $severity = DisasterSeverityResolver::resolve($data);

        return [
            ...$data,
            'tingkat_keparahan' => $severity['tingkat_keparahan'],
        ];
    }

    private static function syncLocationFromRegionSelection($get, $set, ?Select $component = null): void
    {
        $coordinates = JemberRegion::coordinatesForSelection($get('kecamatan'), $get('desa'));

        if (! $coordinates) {
            return;
        }

        $set('lokasi_map', $coordinates);
        $set('latitude', $coordinates['lat']);
        $set('longitude', $coordinates['lng']);

        $component?->getLivewire()->dispatch('refreshMap', zoom: static::REGION_SELECTION_ZOOM);
    }

    private static function hydrateMapFromCoordinates(Map $component, $get): void
    {
        $latitude = $get('latitude');
        $longitude = $get('longitude');

        if (blank($latitude) || blank($longitude)) {
            return;
        }

        $component->rawState([
            'lat' => (float) $latitude,
            'lng' => (float) $longitude,
        ]);
    }

    private static function severitySummary($get): string
    {
        $severity = DisasterSeverityResolver::resolve([
            'jumlah_korban' => $get('jumlah_korban'),
            'jumlah_terdampak' => $get('jumlah_terdampak'),
            'rumah_rusak' => $get('rumah_rusak'),
            'fasilitas_vital_lumpuh' => $get('fasilitas_vital_lumpuh'),
        ]);

        $visibility = $severity['eligible_for_campaign']
            ? 'Memenuhi ambang kampanye donasi.'
            : 'Tersimpan sebagai Insiden Lokal.';

        return $severity['severity_label'].' - '.$visibility;
    }
}
