<?php

namespace App\Filament\Admin\Resources\BankAccounts\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BankAccountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_bank')
                    ->label('Bank')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('nomor_rekening')
                    ->label('Nomor Rekening')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('nama_pemilik')
                    ->label('Nama Pemilik')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
