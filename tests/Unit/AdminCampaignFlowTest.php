<?php

namespace Tests\Unit;

use App\Filament\Admin\Resources\Campaigns\Pages\CreateCampaign;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;

class AdminCampaignFlowTest extends TestCase
{
    public function test_admin_created_campaign_is_active_and_reviewed_immediately(): void
    {
        Auth::swap(new \Illuminate\Auth\AuthManager(app()));

        $admin = new class
        {
            public int $id = 99;

            public function isAdmin(): bool
            {
                return true;
            }
        };

        Auth::shouldReceive('user')->andReturn($admin);
        Auth::shouldReceive('id')->andReturn($admin->id);

        $page = app(CreateCampaign::class);

        $method = new \ReflectionMethod($page, 'mutateFormDataBeforeCreate');
        $method->setAccessible(true);

        $result = $method->invoke($page, []);

        $this->assertSame(Campaign::STATUS_ACTIVE, $result['status']);
        $this->assertNull($result['submitted_for_review_at']);
        $this->assertSame($admin->id, $result['reviewed_by']);
        $this->assertNotNull($result['reviewed_at']);
        $this->assertNull($result['rejection_reason']);
    }

    public function test_non_admin_created_campaign_stays_pending_review(): void
    {
        Auth::swap(new \Illuminate\Auth\AuthManager(app()));

        $user = new class
        {
            public function isAdmin(): bool
            {
                return false;
            }
        };

        Auth::shouldReceive('user')->andReturn($user);

        $page = app(CreateCampaign::class);

        $method = new \ReflectionMethod($page, 'mutateFormDataBeforeCreate');
        $method->setAccessible(true);

        $result = $method->invoke($page, []);

        $this->assertSame(Campaign::STATUS_PENDING, $result['status']);
        $this->assertNotNull($result['submitted_for_review_at']);
        $this->assertNull($result['reviewed_by']);
        $this->assertNull($result['reviewed_at']);
        $this->assertNull($result['rejection_reason']);
    }
}
