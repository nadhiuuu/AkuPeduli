<?php

namespace App\Filament\Admin\Resources\CampaignReviews;

use App\Filament\Admin\Resources\CampaignReviews\Pages\EditCampaignReview;
use App\Filament\Admin\Resources\CampaignReviews\Pages\ListCampaignReviews;
use App\Filament\Admin\Resources\CampaignReviews\Schemas\CampaignReviewForm;
use App\Filament\Admin\Resources\CampaignReviews\Tables\CampaignReviewsTable;
use App\Models\Campaign;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class CampaignReviewResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Review Campaign';
    protected static ?string $pluralModelLabel = 'Review Campaign';
    protected static string|UnitEnum|null $navigationGroup = 'Moderasi';
    protected static ?int $navigationSort = 5;

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()
            ->where('status', Campaign::STATUS_PENDING)
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['category', 'impact', 'user', 'reviewer']);
    }

    public static function form(Schema $schema): Schema
    {
        return CampaignReviewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CampaignReviewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCampaignReviews::route('/'),
            'edit' => EditCampaignReview::route('/{record}/edit'),
        ];
    }
}
