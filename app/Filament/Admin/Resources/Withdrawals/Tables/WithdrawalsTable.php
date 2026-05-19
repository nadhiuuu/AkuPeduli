<?php

namespace App\Filament\Admin\Resources\Withdrawals\Tables;

use App\Models\Campaign;
use App\Models\Withdrawal;
use App\Services\WithdrawalService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WithdrawalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('requested_at', 'desc')
            ->columns([
                TextColumn::make('campaign.title')
                    ->label('Campaign')
                    ->searchable()
                    ->limit(28)
                    ->weight('bold'),

                TextColumn::make('user.name')
                    ->label('Campaigner')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->visible(fn (): bool => Auth::user()?->isAdmin() ?? false),

                TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->color('success'),

                TextColumn::make('bank_name_snapshot')
                    ->label('Bank')
                    ->searchable()
                    ->description(fn (Withdrawal $record): string => $record->account_holder_snapshot),

                TextColumn::make('account_number_snapshot')
                    ->label('No. Rekening')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Withdrawal::statusOptions()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        Withdrawal::STATUS_PENDING => 'warning',
                        Withdrawal::STATUS_TRANSFERRED => 'success',
                        Withdrawal::STATUS_REJECTED => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('requested_at')
                    ->label('Tanggal Ajukan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('transferred_at')
                    ->label('Tanggal Transfer')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('rejection_reason')
                    ->label('Alasan Penolakan')
                    ->limit(40)
                    ->wrap()
                    ->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(Withdrawal::statusOptions()),
                SelectFilter::make('campaign_id')
                    ->label('Filter Campaign')
                    ->relationship(
                        'campaign',
                        'title',
                        modifyQueryUsing: fn (Builder $query) => Auth::user()?->isAdmin()
                            ? $query
                            : $query->where('user_id', Auth::id()),
                    )
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                Action::make('approveTransfer')
                    ->label('Setujui & Tandai Sudah Ditransfer')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Withdrawal $record): bool => (Auth::user()?->isAdmin() ?? false) && $record->status === Withdrawal::STATUS_PENDING)
                    ->action(function (Withdrawal $record): void {
                        try {
                            app(WithdrawalService::class)->approveAndTransfer($record, Auth::user());

                            Notification::make()
                                ->title('Pencairan berhasil ditandai sudah ditransfer')
                                ->success()
                                ->send();
                        } catch (ValidationException $exception) {
                            Notification::make()
                                ->title('Pencairan gagal diproses')
                                ->body(collect($exception->errors())->flatten()->join(' '))
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(4),
                    ])
                    ->visible(fn (Withdrawal $record): bool => (Auth::user()?->isAdmin() ?? false) && $record->status === Withdrawal::STATUS_PENDING)
                    ->action(function (array $data, Withdrawal $record): void {
                        try {
                            app(WithdrawalService::class)->reject($record, Auth::user(), $data['rejection_reason']);

                            Notification::make()
                                ->title('Pencairan berhasil ditolak')
                                ->success()
                                ->send();
                        } catch (ValidationException $exception) {
                            Notification::make()
                                ->title('Pencairan gagal ditolak')
                                ->body(collect($exception->errors())->flatten()->join(' '))
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->toolbarActions([
                Action::make('requestWithdrawal')
                    ->label('Ajukan Pencairan')
                    ->icon('heroicon-o-banknotes')
                    ->color('primary')
                    ->visible(fn (): bool => ! (Auth::user()?->isAdmin() ?? true))
                    ->disabled(fn (): bool => Auth::user()?->bankAccounts()->doesntExist() ?? true)
                    ->form([
                        Select::make('campaign_id')
                            ->label('Pilih Campaign')
                            ->options(fn (): array => Campaign::query()
                                ->where('user_id', Auth::id())
                                ->whereHas('user', fn (Builder $query) => $query->where('role', 'user'))
                                ->where('current_amount', '>', 0)
                                ->whereDoesntHave('withdrawals', fn (Builder $query) => $query->where('status', Withdrawal::STATUS_PENDING))
                                ->orderBy('title')
                                ->pluck('title', 'id')
                                ->all())
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Nominal pencairan otomatis mengambil seluruh saldo campaign saat ini. Jika rekening belum tersedia, kelola dulu di menu Rekening Bank.'),
                    ])
                    ->action(function (array $data): void {
                        try {
                            $campaign = Campaign::query()->findOrFail($data['campaign_id']);
                            app(WithdrawalService::class)->create(Auth::user(), $campaign);

                            Notification::make()
                                ->title('Pengajuan pencairan berhasil dibuat')
                                ->success()
                                ->send();
                        } catch (ValidationException $exception) {
                            Notification::make()
                                ->title('Pengajuan pencairan gagal dibuat')
                                ->body(collect($exception->errors())->flatten()->join(' '))
                                ->danger()
                                ->send();
                        }
                    }),
            ]);
    }
}
