<?php

namespace App\Filament\Admin\Resources\Documentations\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;

class DocumentationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('campaign_id')
                    ->relationship(
                        name : 'campaign',
                        titleAttribute: 'title',
                        modifyQueryUsing: fn ($query) => $query->where('status', 'aktif')
                    )
                    
                    ->required()
                    ->preload()
                    ->searchable(),

                DatePicker::make('tgl_penyerahan')
                    ->required()
                    ->minDate(now())
                    ->native(false),

                TextInput::make('nama_penerima')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('bukti_foto')
                    ->required()
                    ->image()
                    ->directory('documentation')
                    ->maxSize(5120),
            ]);
    }
}
