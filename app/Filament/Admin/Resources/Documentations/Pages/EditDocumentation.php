<?php

namespace App\Filament\Admin\Resources\Documentations\Pages;

use App\Filament\Admin\Resources\Documentations\DocumentationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDocumentation extends EditRecord
{
    protected static string $resource = DocumentationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
