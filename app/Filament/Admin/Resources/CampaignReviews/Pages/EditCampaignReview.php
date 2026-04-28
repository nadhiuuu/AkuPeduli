<?php

namespace App\Filament\Admin\Resources\CampaignReviews\Pages;

use App\Filament\Admin\Resources\CampaignReviews\CampaignReviewResource;
use App\Models\Campaign;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCampaignReview extends EditRecord
{
    protected static string $resource = CampaignReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('Simpan Koreksi & Aktifkan')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->persistFormData();

                    $this->record->update([
                        'status' => Campaign::STATUS_ACTIVE,
                        'reviewed_by' => auth()->id(),
                        'reviewed_at' => now(),
                        'rejection_reason' => null,
                    ]);

                    Notification::make()
                        ->title('Campaign berhasil diaktifkan')
                        ->success()
                        ->send();
                }),
            Action::make('reject')
                ->label('Tolak Campaign')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->form([
                    \Filament\Forms\Components\Textarea::make('rejection_reason')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->rows(4),
                ])
                ->action(function (array $data): void {
                    $this->persistFormData();

                    $this->record->update([
                        'status' => Campaign::STATUS_REJECTED,
                        'reviewed_by' => auth()->id(),
                        'reviewed_at' => now(),
                        'rejection_reason' => $data['rejection_reason'],
                    ]);

                    $this->fillForm();

                    Notification::make()
                        ->title('Campaign ditolak')
                        ->success()
                        ->send();
                }),
            Action::make('returnToPending')
                ->label('Kembalikan ke Pending')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update([
                        'status' => Campaign::STATUS_PENDING,
                        'reviewed_by' => null,
                        'reviewed_at' => null,
                        'rejection_reason' => null,
                        'submitted_for_review_at' => now(),
                    ]);

                    $this->fillForm();

                    Notification::make()
                        ->title('Campaign dikembalikan ke antrean review')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('Simpan Koreksi');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['reviewed_by'] = auth()->id();
        $data['reviewed_at'] = now();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function persistFormData(): void
    {
        $data = $this->mutateFormDataBeforeSave($this->form->getState());

        $this->handleRecordUpdate($this->getRecord(), $data);
        $this->record->refresh();
    }
}
