<?php

namespace App\Notifications;

use App\Filament\Admin\Resources\CampaignerProfiles\CampaignerProfileResource;
use App\Models\CampaignerProfile;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminCampaignerVerificationPendingNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected CampaignerProfile $campaignerProfile,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $campaignerName = $this->campaignerProfile->user?->name ?? 'Campaigner';

        return FilamentNotification::make()
            ->title('Verifikasi campaigner menunggu review')
            ->body("{$campaignerName} telah mengirim data verifikasi dan siap ditinjau admin.")
            ->icon('heroicon-o-bell')
            ->iconColor('warning')
            ->actions([
                Action::make('review')
                    ->label('Tinjau')
                    ->url(CampaignerProfileResource::getUrl('index')),
            ])
            ->getDatabaseMessage();
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
