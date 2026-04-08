<?php

namespace App\Filament\Admin\Resources\DisasterCategories;

use App\Filament\Admin\Resources\DisasterCategories\Pages\CreateDisasterCategory;
use App\Filament\Admin\Resources\DisasterCategories\Pages\EditDisasterCategory;
use App\Filament\Admin\Resources\DisasterCategories\Pages\ListDisasterCategories;
use App\Filament\Admin\Resources\DisasterCategories\Schemas\DisasterCategoryForm;
use App\Filament\Admin\Resources\DisasterCategories\Tables\DisasterCategoriesTable;
use App\Models\DisasterCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DisasterCategoryResource extends Resource
{
    protected static ?string $model = DisasterCategory::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-list-bullet';

    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin';
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DisasterCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DisasterCategoriesTable::configure($table);
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
            'index' => ListDisasterCategories::route('/'),
            'create' => CreateDisasterCategory::route('/create'),
            'edit' => EditDisasterCategory::route('/{record}/edit'),
        ];
    }
}
