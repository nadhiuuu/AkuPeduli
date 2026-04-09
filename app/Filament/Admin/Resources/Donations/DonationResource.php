<?php

namespace App\Filament\Admin\Resources\Donations;

use App\Filament\Admin\Resources\Donations\Pages\ListDonations;
use App\Filament\Admin\Resources\Donations\Pages\ViewDonation;
use App\Filament\Admin\Resources\Donations\Schemas\DonationForm;
use App\Filament\Admin\Resources\Donations\Schemas\DonationInfolist;
use App\Filament\Admin\Resources\Donations\Tables\DonationsTable;
use App\Models\Donation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    // Ganti icon dan label menu
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Data Donatur';
    protected static ?string $pluralModelLabel = 'Data Donatur';

    // KUNCI KEAMANAN: Matikan tombol "New Donation"
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return DonationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DonationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DonationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        // Hapus rute 'create' dan 'edit' agar tidak bisa diakses sama sekali
        return [
            'index' => ListDonations::route('/'),
            'view' => ViewDonation::route('/{record}'),
        ];
    }
}