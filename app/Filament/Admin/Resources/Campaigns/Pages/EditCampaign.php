<?php

namespace App\Filament\Admin\Resources\Campaigns\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignResource;
use App\Filament\Admin\Resources\Campaigns\Schemas\CampaignForm;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\Concerns\HasWizard;
use Filament\Schemas\Components\Component;

class EditCampaign extends EditRecord
{
    use HasWizard {
        getWizardComponent as protected getBaseWizardComponent;
    }

    protected static string $resource = CampaignResource::class;

    public function getSteps(): array
    {
        return CampaignForm::getSteps();
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
}
