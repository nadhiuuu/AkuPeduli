<?php

namespace App\Filament\Admin\Resources\Campaigns\Schemas;

use App\Models\Campaign;
use App\Support\DisasterSeverityResolver;
use App\Support\JemberRegion;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload as FormsFileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(static::getCampaignFields());
    }

    public static function getSteps(): array
    {
        return [
            Step::make('Informasi Campaign')
                ->description('Lengkapi data utama campaign terlebih dahulu.')
                ->schema(static::getCampaignFields()),
            Step::make('Disaster Impact')
                ->description('Masukkan dampak bencana dan lokasi sesuai verifikasi lapangan.')
                ->schema([
                    static::getImpactSection(),
                ]),
        ];
    }

    public static function getCampaignFields(): array
    {
        return [
            TextInput::make('title')
                ->label('Judul Galang Dana')
                ->required()
                ->minLength(10)
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
                ->default(fn () => Auth::id())
                ->disabled()
                ->dehydrated()
                ->required(),

            TextInput::make('target_amount')
                ->label('Target Donasi')
                ->numeric()
                ->prefix('Rp')
                ->minValue(100000)
                ->helperText('Minimal target donasi adalah Rp 100.000')
                ->required(),

            TextInput::make('current_amount')
                ->label('Terkumpul Saat Ini')
                ->numeric()
                ->prefix('Rp')
                ->default(0)
                ->disabled()
                ->dehydrated()
                ->helperText('Otomatis bertambah saat ada donasi berhasil.'),

            DatePicker::make('end_date')
                ->label('Batas Waktu')
                ->minDate(now())
                ->required(),

            Select::make('status')
                ->label('Status Galang Dana')
                ->options(Campaign::statusOptions())
                ->default(Campaign::STATUS_PENDING)
                ->hidden(fn () => ! Auth::user()?->isAdmin())
                ->disabled(fn (?Model $record) => ! $record)
                ->dehydrated()
                ->required(),

            FormsFileUpload::make('image')
                ->label('Banner Galang Dana')
                ->image()
                ->disk('public')
                ->directory('campaigns')
                ->visibility('public')
                ->imageEditor()
                ->deleteUploadedFileUsing(fn (string $file): bool => tap(true, fn () => Campaign::deleteStoredFile($file)))
                ->columnSpanFull()
                ->maxSize(5120),

            RichEditor::make('description')
                ->label('Cerita / Deskripsi Bencana')
                ->columnSpanFull()
                ->required(),
        ];
    }

    public static function getImpactSection(): Section
    {
        return Section::make('Data Disaster Impact')
            ->relationship('impact')
            ->mutateRelationshipDataBeforeFillUsing(fn (array $data): array => static::mutateImpactData($data))
            ->mutateRelationshipDataBeforeCreateUsing(fn (array $data): array => static::mutateImpactData($data))
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
                            ->required(),

                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->minValue(-90)
                            ->maxValue(90)
                            ->required(),

                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->minValue(-180)
                            ->maxValue(180)
                            ->required(),

                        TextInput::make('jumlah_korban')
                            ->label('Jumlah Meninggal')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required(),

                        TextInput::make('jumlah_terdampak')
                            ->label('Jumlah Terdampak')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required(),

                        TextInput::make('rumah_rusak')
                            ->label('Rumah Rusak')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required(),

                        Checkbox::make('fasilitas_vital_lumpuh')
                            ->label('Fasilitas Vital Lumpuh')
                            ->default(false),

                        TextInput::make('kerugian_materil')
                            ->label('Kerugian Materil / Infrastruktur')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->minValue(0)
                            ->required(),

                        Select::make('tingkat_keparahan')
                            ->label('Status Bencana Otomatis')
                            ->options(DisasterSeverityResolver::options())
                            ->default(DisasterSeverityResolver::LOCAL)
                            ->disabled()
                            ->dehydrated()
                            ->visible(fn () => Auth::user()?->isAdmin())
                            ->helperText('Dihitung otomatis dari data dampak final dan tidak bisa diubah manual.'),

                        Placeholder::make('severity_preview')
                            ->label('Ringkasan Status')
                            ->content(fn ($get): string => static::severitySummary($get))
                            ->visible(fn () => Auth::user()?->isAdmin())
                            ->columnSpanFull(),

                        Placeholder::make('review_privacy_notice')
                            ->label('Status Bencana')
                            ->content('Status bencana disembunyikan dari campaigner dan baru ditampilkan pada proses review admin.')
                            ->visible(fn () => ! Auth::user()?->isAdmin())
                            ->columnSpanFull(),
                    ]),

                FormsFileUpload::make('bukti_surat_bpbd')
                    ->label('Bukti / Surat BPBD')
                    ->disk('public')
                    ->directory('disaster-impacts/bpbd')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->acceptedFileTypes([
                        'application/pdf',
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ])
                    ->helperText('Opsional. Unggah PDF atau gambar bukti dari BPBD.')
                    ->maxSize(5120),
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
