<?php

namespace App\Filament\Admin\Resources\CampaignReviews\Pages;

use App\Filament\Admin\Resources\CampaignReviews\CampaignReviewResource;
use Filament\Resources\Pages\ListRecords;

class ListCampaignReviews extends ListRecords
{
    protected static string $resource = CampaignReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
