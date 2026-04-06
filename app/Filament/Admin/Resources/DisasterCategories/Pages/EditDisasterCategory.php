<?php

namespace App\Filament\Admin\Resources\DisasterCategories\Pages;

use App\Filament\Admin\Resources\DisasterCategories\DisasterCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDisasterCategory extends EditRecord
{
    protected static string $resource = DisasterCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
