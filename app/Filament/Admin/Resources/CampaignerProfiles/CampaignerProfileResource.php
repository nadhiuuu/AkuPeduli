<?php

namespace App\Filament\Admin\Resources\CampaignerProfiles;

use App\Filament\Admin\Resources\CampaignerProfiles\Pages\CreateCampaignerProfile;
use App\Filament\Admin\Resources\CampaignerProfiles\Pages\EditCampaignerProfile;
use App\Filament\Admin\Resources\CampaignerProfiles\Pages\ListCampaignerProfiles;
use App\Filament\Admin\Resources\CampaignerProfiles\Schemas\CampaignerProfileForm;
use App\Filament\Admin\Resources\CampaignerProfiles\Tables\CampaignerProfilesTable;
use App\Models\CampaignerProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CampaignerProfileResource extends Resource
{
    protected static ?string $model = CampaignerProfile::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CampaignerProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CampaignerProfilesTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Pengguna')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('user.name')->label('Nama Pengguna'),
                        \Filament\Infolists\Components\TextEntry::make('no_wa')->label('Nomor WhatsApp'),
                        \Filament\Infolists\Components\TextEntry::make('email_campaigner')->label('Email Campaigner'),
                    ])->columns(3),

                \Filament\Schemas\Components\Section::make('Informasi Bank')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('nama_bank')
                            ->label('Nama Bank')
                            ->default(fn ($record) => $record->user->bankAccounts->first()?->nama_bank ?? '-'),
                        \Filament\Infolists\Components\TextEntry::make('nomor_rekening')
                            ->label('Nomor Rekening')
                            ->default(fn ($record) => $record->user->bankAccounts->first()?->nomor_rekening ?? '-'),
                        \Filament\Infolists\Components\TextEntry::make('nama_pemilik')
                            ->label('Pemilik Rekening')
                            ->default(fn ($record) => $record->user->bankAccounts->first()?->nama_pemilik ?? '-'),
                    ])->columns(3),

                \Filament\Schemas\Components\Section::make('Dokumen Identitas')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('nik')
                            ->label('NIK')
                            ->columnSpanFull(),
                        \Filament\Infolists\Components\ImageEntry::make('foto_ktp')
                            ->label('Scan KTP')
                            ->disk('public')
                            ->width('100%')
                            ->height(300),
                        \Filament\Infolists\Components\ImageEntry::make('foto_selfie_ktp')
                            ->label('Selfie dengan KTP')
                            ->disk('public')
                            ->width('100%')
                            ->height(300),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Status Verifikasi')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('status_verifikasi')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'menunggu' => 'warning',
                                'disetujui' => 'success',
                                'ditolak' => 'danger',
                                default => 'gray',
                            }),
                        \Filament\Infolists\Components\TextEntry::make('alasan_penolakan')
                            ->visible(fn ($record) => $record->status_verifikasi === 'ditolak'),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCampaignerProfiles::route('/'),
        ];
    }
}
