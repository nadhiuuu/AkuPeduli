<?php

namespace App\Filament\Admin\Resources\CampaignerProfiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CampaignerProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('nik')
                    ->searchable(),
                \Filament\Tables\Columns\ImageColumn::make('foto_ktp')
                    ->disk('public')
                    ->label('Foto KTP')
                    ->square()
                    ->size(60),
                \Filament\Tables\Columns\ImageColumn::make('foto_selfie_ktp')
                    ->disk('public')
                    ->label('Selfie KTP')
                    ->square()
                    ->size(60),
                TextColumn::make('status_verifikasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\Action::make('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (\App\Models\CampaignerProfile $record): bool => $record->status_verifikasi === 'menunggu')
                    ->action(fn (\App\Models\CampaignerProfile $record) => $record->update(['status_verifikasi' => 'disetujui'])),
                
                \Filament\Actions\Action::make('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        \Filament\Forms\Components\Textarea::make('alasan_penolakan')
                            ->required()
                            ->label('Alasan Penolakan')
                    ])
                    ->visible(fn (\App\Models\CampaignerProfile $record): bool => $record->status_verifikasi === 'menunggu')
                    ->action(fn (array $data, \App\Models\CampaignerProfile $record) => $record->update([
                        'status_verifikasi' => 'ditolak',
                        'alasan_penolakan' => $data['alasan_penolakan']
                    ])),


                \Filament\Actions\ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
