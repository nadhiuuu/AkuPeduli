<?php

namespace App\Filament\Admin\Resources\Documentations\Pages;

use App\Filament\Admin\Resources\Documentations\DocumentationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDocumentations extends ListRecords
{
    protected static string $resource = DocumentationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
