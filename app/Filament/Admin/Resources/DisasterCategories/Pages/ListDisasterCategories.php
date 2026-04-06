<?php

namespace App\Filament\Admin\Resources\DisasterCategories\Pages;

use App\Filament\Admin\Resources\DisasterCategories\DisasterCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDisasterCategories extends ListRecords
{
    protected static string $resource = DisasterCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
