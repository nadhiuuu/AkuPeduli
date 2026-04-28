<?php

namespace App\Filament\Admin\Resources\Campaigns\Schemas;

use App\Models\Campaign;
use Filament\Forms\Components\FileUpload as FormsFileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
                ->description('Masukkan dampak bencana dan lokasi untuk kebutuhan AI heatmap.')
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
            ->mutateRelationshipDataBeforeFillUsing(fn (array $data): array => [
                ...$data,
                'tingkat_keparahan' => $data['tingkat_keparahan'] ?? 'pending_ai',
            ])
            ->mutateRelationshipDataBeforeCreateUsing(fn (array $data): array => [
                ...$data,
                'tingkat_keparahan' => $data['tingkat_keparahan'] ?? 'pending_ai',
            ])
            ->mutateRelationshipDataBeforeSaveUsing(fn (array $data): array => [
                ...$data,
                'tingkat_keparahan' => $data['tingkat_keparahan'] ?? 'pending_ai',
            ])
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('kecamatan')
                            ->label('Kecamatan')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('desa')
                            ->label('Desa / Kelurahan')
                            ->required()
                            ->maxLength(255),

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
                            ->label('Jumlah Korban Jiwa')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required(),

                        TextInput::make('jumlah_pengungsi')
                            ->label('Jumlah Pengungsi')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required(),

                        TextInput::make('luas_wilayah_ha')
                            ->label('Luas Wilayah Terdampak (Ha)')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required(),

                        TextInput::make('kerugian_materil')
                            ->label('Kerugian Materil / Infrastruktur')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->minValue(0)
                            ->required(),

                        Select::make('tingkat_keparahan')
                            ->label('Tingkat Keparahan (Hasil AI)')
                            ->options([
                                'pending_ai' => 'Menunggu Hasil AI',
                                '1 - sangat ringan' => '1 - Sangat Ringan',
                                '2 - ringan' => '2 - Ringan',
                                '3 - sedang' => '3 - Sedang',
                                '4 - parah' => '4 - Parah',
                                '5 - sangat parah' => '5 - Sangat Parah',
                            ])
                            ->default('pending_ai')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->helperText('Diisi otomatis oleh AI setelah analisis.'),
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
}
