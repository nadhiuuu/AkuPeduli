<?php

namespace App\Filament\Admin\Resources\Documentations\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Tables\Filters\SelectFilter;

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
                ->label('Dibuat Pada')
                ->getStateUsing(fn ($record) => $record->created_at)
                ->formatStateUsing(fn ($state) => 
                    $state ? \Carbon\Carbon::parse($state)->format('d M Y H:i') : '-'
                ),

            TextEntry::make('updated_at')
                ->dateTime()
                ->placeholder('-'),

        ]);
    }
}