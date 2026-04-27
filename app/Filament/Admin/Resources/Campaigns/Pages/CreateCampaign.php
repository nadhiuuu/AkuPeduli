<?php

namespace App\Filament\Admin\Resources\Campaigns\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignResource;
use App\Filament\Admin\Resources\Campaigns\Schemas\CampaignForm;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Concerns\HasWizard;
use Filament\Schemas\Components\Component;

class CreateCampaign extends CreateRecord
{
    use HasWizard {
        getWizardComponent as protected getBaseWizardComponent;
    }

    protected static string $resource = CampaignResource::class;

    public function getSteps(): array
    {
        return CampaignForm::getSteps();
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
}
