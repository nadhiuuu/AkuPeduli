<?php

namespace App\Filament\Admin\Resources\CampaignerProfiles\Pages;

use App\Filament\Admin\Resources\CampaignerProfiles\CampaignerProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCampaignerProfiles extends ListRecords
{
    protected static string $resource = CampaignerProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
