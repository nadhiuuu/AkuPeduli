<?php

namespace App\Filament\Admin\Resources\Withdrawals;

use App\Filament\Admin\Resources\Withdrawals\Pages\ListWithdrawals;
use App\Filament\Admin\Resources\Withdrawals\Tables\WithdrawalsTable;
use App\Models\Withdrawal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Pencairan Dana';
    protected static ?string $pluralModelLabel = 'Pencairan Dana';
    protected static string|UnitEnum|null $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return auth()->user()?->canAccessDashboard() ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        $user = auth()->user();

        if (! $user) {
            return null;
        }

        $query = static::getModel()::query()->where('status', Withdrawal::STATUS_PENDING);

        if (! $user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $count = $query->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['campaign', 'user', 'bankAccount', 'approver', 'rejector']);
        $user = auth()->user();

        if (! $user || $user->isAdmin()) {
            return $query;
        }

        return $query->where('user_id', $user->id);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return WithdrawalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWithdrawals::route('/'),
        ];
    }
}
