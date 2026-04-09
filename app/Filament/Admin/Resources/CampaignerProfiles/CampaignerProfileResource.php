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

    protected static ?string $recordTitleAttribute = 'CampaignerProfile';

    public static function form(Schema $schema): Schema
    {
        return CampaignerProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CampaignerProfilesTable::configure($table);
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
            'create' => CreateCampaignerProfile::route('/create'),
            'edit' => EditCampaignerProfile::route('/{record}/edit'),
        ];
    }
}
