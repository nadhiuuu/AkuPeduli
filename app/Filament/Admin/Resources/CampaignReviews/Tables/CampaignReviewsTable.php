<?php

namespace App\Filament\Admin\Resources\CampaignReviews\Tables;

use App\Models\Campaign;
use App\Support\DisasterSeverityResolver;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CampaignReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('submitted_for_review_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Campaign')
                    ->searchable()
                    ->limit(40)
                    ->weight('bold'),
                TextColumn::make('user.name')
                    ->label('Pengaju')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),
                TextColumn::make('impact.jumlah_korban')
                    ->label('Meninggal')
                    ->numeric(),
                TextColumn::make('impact.jumlah_terdampak')
                    ->label('Terdampak')
                    ->numeric(),
                TextColumn::make('impact.rumah_rusak')
                    ->label('Rumah Rusak')
                    ->numeric(),
                TextColumn::make('impact.tingkat_keparahan')
                    ->label('Status Bencana')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => DisasterSeverityResolver::labelFor($state))
                    ->color(fn (?string $state): string => match ($state) {
                        DisasterSeverityResolver::SIAGA => 'warning',
                        DisasterSeverityResolver::MENENGAH => 'info',
                        DisasterSeverityResolver::KRITIS => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('impact.bukti_surat_bpbd')
                    ->label('Surat Bukti')
                    ->formatStateUsing(fn (?string $state): string => $state ? 'Tersedia' : 'Belum Ada')
                    ->badge()
                    ->color(fn (?string $state): string => $state ? 'success' : 'gray'),
                TextColumn::make('submitted_for_review_at')
                    ->label('Tanggal Submit')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Campaign::statusOptions()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        Campaign::STATUS_PENDING => 'warning',
                        Campaign::STATUS_ACTIVE => 'success',
                        Campaign::STATUS_REJECTED => 'danger',
                        Campaign::STATUS_COMPLETED => 'info',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Review')
                    ->options(Campaign::statusOptions())
                    ->default(Campaign::STATUS_PENDING),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Review & Koreksi'),
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Campaign $record): bool => $record->status !== Campaign::STATUS_ACTIVE)
                    ->action(function (Campaign $record): void {
                        $record->update([
                            'status' => Campaign::STATUS_ACTIVE,
                            'reviewed_by' => auth()->id(),
                            'reviewed_at' => now(),
                            'rejection_reason' => null,
                        ]);
                    }),
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        \Filament\Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(4),
                    ])
                    ->visible(fn (Campaign $record): bool => $record->status !== Campaign::STATUS_REJECTED)
                    ->action(function (array $data, Campaign $record): void {
                        $record->update([
                            'status' => Campaign::STATUS_REJECTED,
                            'reviewed_by' => auth()->id(),
                            'reviewed_at' => now(),
                            'rejection_reason' => $data['rejection_reason'],
                        ]);
                    }),
                Action::make('returnToPending')
                    ->label('Kembalikan ke Pending')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (Campaign $record): bool => $record->status !== Campaign::STATUS_PENDING)
                    ->action(function (Campaign $record): void {
                        $record->update([
                            'status' => Campaign::STATUS_PENDING,
                            'reviewed_by' => null,
                            'reviewed_at' => null,
                            'rejection_reason' => null,
                            'submitted_for_review_at' => now(),
                        ]);
                    }),
                Action::make('lihatWeb')
                    ->label('Lihat Publik')
                    ->icon('heroicon-o-globe-alt')
                    ->color('info')
                    ->visible(fn (Campaign $record): bool => $record->status === Campaign::STATUS_ACTIVE)
                    ->url(fn (Campaign $record): string => route('donation.detail', $record->slug))
                    ->openUrlInNewTab(),
            ]);
    }
}
