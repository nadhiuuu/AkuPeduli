<?php

namespace App\Notifications;

use App\Filament\Admin\Resources\CampaignReviews\CampaignReviewResource;
use App\Models\Campaign;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminCampaignPendingReviewNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Campaign $campaign,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $campaignTitle = $this->campaign->title;
        $campaignerName = $this->campaign->user?->name ?? 'Campaigner';

        return FilamentNotification::make()
            ->title('Campaign menunggu verifikasi admin')
            ->body("{$campaignerName} mengirim campaign \"{$campaignTitle}\" untuk ditinjau.")
            ->icon('heroicon-o-document-magnifying-glass')
            ->iconColor('warning')
            ->actions([
                Action::make('review')
                    ->label('Review Campaign')
                    ->url(CampaignReviewResource::getUrl('edit', ['record' => $this->campaign])),
            ])
            ->getDatabaseMessage();
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
