<?php

namespace App\Filament\Admin\Resources\Documentations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
class DocumentationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
            $query->whereHas('campaign', function ($q) {
                $q->where('user_id', Auth::id());
            });
        })
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
                    ->label('Bukti Foto')
                    ->disk('public'),

                TextColumn::make('created_at')
                ->label('Dibuat Pada')
                ->dateTime('d M Y H:i')
                ->sortable(),
                
                TextColumn::make('attachment')
                ->label('Lampiran')
                ->formatStateUsing(function ($state) {
                    if (!$state) return '-';

                    $ext = pathinfo($state, PATHINFO_EXTENSION);

                    return match ($ext) {
                        'pdf' => '📄 PDF',
                        'xls', 'xlsx' => '📊 Excel',
                        default => '📁 File',
                    };
                })
                ->url(fn ($record) => $record->attachment 
                    ? asset('storage/' . $record->attachment) 
                    : null)
                ->openUrlInNewTab(),

            ])
            ->filters([
                SelectFilter::make('campaign_id')
                    ->relationship('campaign', 'title')
                    ->label('Filter Campaign'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordActions([
                Action::make('Lihat Web')
                    ->icon('heroicon-o-globe-alt')
                    ->color('info')
                    ->url(fn ($record): string => route('documentation.detail', $record->slug))                ->openUrlInNewTab(),
                EditAction::make(),
        ]);
    }
}