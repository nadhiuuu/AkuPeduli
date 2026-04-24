<?php

namespace App\Notifications;

use App\Models\Donation;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CampaignDonationReceivedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Donation $donation,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $campaignTitle = $this->donation->campaign?->title ?? 'Campaign';
        $donorName = $this->donation->donor_name ?: 'Donatur';
        $amount = number_format((int) $this->donation->gross_amount, 0, ',', '.');

        return FilamentNotification::make()
            ->title('Donasi berhasil masuk')
            ->body("{$donorName} berdonasi Rp {$amount} ke campaign {$campaignTitle}.")
            ->icon('heroicon-o-banknotes')
            ->iconColor('success')
            ->actions([
                Action::make('viewDonation')
                    ->label('Lihat Donasi')
                    ->url(route('filament.admin.resources.donations.view', ['record' => $this->donation])),
            ])
            ->getDatabaseMessage();
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
