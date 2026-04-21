<?php

namespace App\Filament\Admin\Resources\Documentations\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class DocumentationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextEntry::make('campaign.title')
                ->label('Campaign'),

            TextEntry::make('nama_penerima')
                ->label('Nama Penerima'),

            TextEntry::make('tgl_penyerahan')
                ->date(),

            TextEntry::make('deskripsi')
                ->columnSpanFull(),

            ImageEntry::make('bukti_foto')
                ->label('Bukti Foto'),

            TextEntry::make('created_at')
                ->dateTime()
                ->placeholder('-'),

            TextEntry::make('updated_at')
                ->dateTime()
                ->placeholder('-'),

        ]);
    }
}