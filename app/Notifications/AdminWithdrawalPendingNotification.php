<?php

namespace App\Notifications;

use App\Filament\Admin\Resources\Withdrawals\WithdrawalResource;
use App\Models\Withdrawal;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminWithdrawalPendingNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Withdrawal $withdrawal,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $campaignTitle = $this->withdrawal->campaign?->title ?? 'Campaign';
        $campaignerName = $this->withdrawal->user?->name ?? 'Campaigner';

        return FilamentNotification::make()
            ->title('Pencairan dana menunggu persetujuan admin')
            ->body("{$campaignerName} mengajukan pencairan untuk campaign \"{$campaignTitle}\".")
            ->icon('heroicon-o-banknotes')
            ->iconColor('warning')
            ->actions([
                Action::make('review')
                    ->label('Tinjau Pencairan')
                    ->url(WithdrawalResource::getUrl('index')),
            ])
            ->getDatabaseMessage();
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
