<?php

namespace Tests\Unit;

use App\Models\Campaign;
use PHPUnit\Framework\TestCase;

class CampaignStatusTest extends TestCase
{
    public function test_campaign_status_options_match_human_review_flow(): void
    {
        $this->assertSame([
            Campaign::STATUS_PENDING => 'Menunggu Verifikasi Admin',
            Campaign::STATUS_ACTIVE => 'Aktif / Tayang',
            Campaign::STATUS_REJECTED => 'Ditolak',
            Campaign::STATUS_COMPLETED => 'Selesai',
        ], Campaign::statusOptions());
    }

    public function test_only_active_campaign_is_publicly_visible(): void
    {
        $campaign = new Campaign(['status' => Campaign::STATUS_PENDING]);
        $this->assertFalse($campaign->isPubliclyVisible());

        $campaign->status = Campaign::STATUS_ACTIVE;
        $this->assertTrue($campaign->isPubliclyVisible());

        $campaign->status = Campaign::STATUS_REJECTED;
        $this->assertFalse($campaign->isPubliclyVisible());
    }
}
