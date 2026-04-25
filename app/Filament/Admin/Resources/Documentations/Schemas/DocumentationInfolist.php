<?php

namespace App\Filament\Admin\Resources\Documentations\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

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

            TextEntry::make('attachment')
            ->label('Lampiran')
            ->formatStateUsing(function ($state) {
                if (!$state) return '-';

                $ext = pathinfo($state, PATHINFO_EXTENSION);

                $icon = match ($ext) {
                    'pdf' => '📄 PDF',
                    'xls', 'xlsx' => '📊 Excel',
                    default => '📁 File',
                };

                return '<a href="'.asset('storage/'.$state).'" target="_blank" style="color:#2563eb; text-decoration:underline;">'.$icon.'</a>';
            })
            ->html(),

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