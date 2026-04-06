<?php

namespace App\Filament\Admin\Resources\DisasterCategories\Pages;

use App\Filament\Admin\Resources\DisasterCategories\DisasterCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDisasterCategory extends CreateRecord
{
    protected static string $resource = DisasterCategoryResource::class;
}
