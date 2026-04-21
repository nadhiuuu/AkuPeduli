<?php

namespace App\Filament\Admin\Resources\Documentations\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class DocumentationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('campaign_id')
                    ->relationship('campaign', 'title')
                    ->required()
                    ->searchable(),

                DatePicker::make('tgl_penyerahan')
                    ->required(),

                TextInput::make('nama_penerima')
                    ->required()
                    ->maxLength(255),

                Textarea::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('bukti_foto')
                    ->required()
                    ->image()
                    ->directory('documentation'),
            ]);
    }
}
