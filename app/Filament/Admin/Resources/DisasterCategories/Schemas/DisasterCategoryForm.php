<?php

namespace App\Filament\Admin\Resources\DisasterCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DisasterCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('icon')
                    ->default(null),
            ]);
    }
}
