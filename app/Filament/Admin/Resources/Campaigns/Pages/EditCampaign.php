<?php

namespace App\Filament\Admin\Resources\Campaigns\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignResource;
use App\Filament\Admin\Resources\Campaigns\Schemas\CampaignForm;
use App\Models\Campaign;
use App\Models\User;
use App\Notifications\AdminCampaignPendingReviewNotification;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\Concerns\HasWizard;
use Filament\Schemas\Components\Component;
use Illuminate\Support\Facades\Auth;

class EditCampaign extends EditRecord
{
    use HasWizard {
        getWizardComponent as protected getBaseWizardComponent;
    }

    protected static string $resource = CampaignResource::class;

    protected bool $shouldNotifyAdmins = false;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user = Auth::user();

        if (
            $user &&
            ! $user->isAdmin() &&
            $this->record->status === Campaign::STATUS_REJECTED
        ) {
            $data['status'] = Campaign::STATUS_PENDING;
            $data['submitted_for_review_at'] = now();
            $data['reviewed_by'] = null;
            $data['reviewed_at'] = null;
            $data['rejection_reason'] = null;
            $this->shouldNotifyAdmins = true;
        }

        return $data;
    }

    public function getSteps(): array
    {
        return CampaignForm::getSteps();
    }

    protected function afterSave(): void
    {
        if ($this->shouldNotifyAdmins) {
            $this->notifyAdmins();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('Simpan Perubahan');
    }

    public function getWizardComponent(): Component
    {
        return $this->getBaseWizardComponent()
            ->nextAction(fn (Action $action): Action => $action->label('Selanjutnya'))
            ->previousAction(fn (Action $action): Action => $action->label('Sebelumnya'));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function notifyAdmins(): void
    {
        User::query()
            ->where('role', 'admin')
            ->each(fn (User $admin) => $admin->notify(new AdminCampaignPendingReviewNotification($this->record)));
    }
}
