<?php

namespace App\Filament\Admin\Resources\CampaignerProfiles\Pages;

use App\Filament\Admin\Resources\CampaignerProfiles\CampaignerProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCampaignerProfile extends EditRecord
{
    protected static string $resource = CampaignerProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
