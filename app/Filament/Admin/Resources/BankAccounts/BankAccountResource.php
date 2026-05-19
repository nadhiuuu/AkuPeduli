<?php

namespace App\Filament\Admin\Resources\BankAccounts;

use App\Filament\Admin\Resources\BankAccounts\Pages\CreateBankAccount;
use App\Filament\Admin\Resources\BankAccounts\Pages\EditBankAccount;
use App\Filament\Admin\Resources\BankAccounts\Pages\ListBankAccounts;
use App\Filament\Admin\Resources\BankAccounts\Schemas\BankAccountForm;
use App\Filament\Admin\Resources\BankAccounts\Tables\BankAccountsTable;
use App\Models\BankAccount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Rekening Bank';
    protected static ?string $pluralModelLabel = 'Rekening Bank';
    protected static string|UnitEnum|null $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        $user = auth()->user();

        return $user !== null
            && ! $user->isAdmin()
            && $user->canAccessDashboard();
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();

        return $user !== null
            && ! $user->isAdmin()
            && $user->canAccessDashboard()
            && ! $user->bankAccounts()->exists();
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();

        return $user !== null
            && ! $user->isAdmin()
            && $user->canAccessDashboard()
            && (int) $record->user_id === (int) $user->id;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->where('user_id', auth()->id());

        return $query->orderByDesc('updated_at')->orderByDesc('id');
    }

    public static function form(Schema $schema): Schema
    {
        return BankAccountForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BankAccountsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBankAccounts::route('/'),
            'create' => CreateBankAccount::route('/create'),
            'edit' => EditBankAccount::route('/{record}/edit'),
        ];
    }
}
