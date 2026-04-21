<?php

namespace App\Filament\Admin\Resources\Documentations;

use App\Filament\Admin\Resources\Documentations\Pages\CreateDocumentation;
use App\Filament\Admin\Resources\Documentations\Pages\EditDocumentation;
use App\Filament\Admin\Resources\Documentations\Pages\ListDocumentations;
use App\Filament\Admin\Resources\Documentations\Pages\ViewDocumentation;
use App\Filament\Admin\Resources\Documentations\Schemas\DocumentationForm;
use App\Filament\Admin\Resources\Documentations\Schemas\DocumentationInfolist;
use App\Filament\Admin\Resources\Documentations\Tables\DocumentationsTable;
use App\Models\Documentation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DocumentationResource extends Resource
{
    protected static ?string $model = Documentation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getRecordTitle(?\Illuminate\Database\Eloquent\Model $record): string
    {
        return $record->campaign->title ?? 'Documentation';
    }
    
    public static function form(Schema $schema): Schema
    {
        return DocumentationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DocumentationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocumentationsTable::configure($table);
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
            'index' => ListDocumentations::route('/'),
            'create' => CreateDocumentation::route('/create'),
            'view' => ViewDocumentation::route('/{record}'),
            'edit' => EditDocumentation::route('/{record}/edit'),
        ];
    }
}
