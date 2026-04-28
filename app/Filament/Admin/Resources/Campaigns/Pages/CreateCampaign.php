<?php

namespace App\Filament\Admin\Resources\Campaigns\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignResource;
use App\Filament\Admin\Resources\Campaigns\Schemas\CampaignForm;
use App\Models\Campaign;
use App\Models\User;
use App\Notifications\AdminCampaignPendingReviewNotification;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Concerns\HasWizard;
use Filament\Schemas\Components\Component;
use Illuminate\Support\Facades\Auth;

class CreateCampaign extends CreateRecord
{
    use HasWizard {
        getWizardComponent as protected getBaseWizardComponent;
    }

    protected static string $resource = CampaignResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = Campaign::STATUS_PENDING;
        $data['submitted_for_review_at'] = now();
        $data['reviewed_by'] = null;
        $data['reviewed_at'] = null;
        $data['rejection_reason'] = null;

        return $data;
    }

    public function getSteps(): array
    {
        return CampaignForm::getSteps();
    }

    protected function afterCreate(): void
    {
        if (! Auth::user()?->isAdmin()) {
            $this->notifyAdmins();
        }
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan Campaign');
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
