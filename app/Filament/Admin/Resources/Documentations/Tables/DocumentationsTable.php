<?php

namespace App\Filament\Admin\Resources\Documentations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class DocumentationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('campaign.title')
                    ->label('Campaign')
                    ->searchable(),

                TextColumn::make('nama_penerima')
                    ->searchable(),

                TextColumn::make('tgl_penyerahan')
                    ->date()
                    ->sortable(),

                ImageColumn::make('bukti_foto')
                    ->label('Foto'),

                TextColumn::make('dibuat_pada')
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}