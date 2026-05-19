<?php

namespace Tests\Feature;

use App\Filament\Admin\Resources\BankAccounts\BankAccountResource;
use App\Filament\Admin\Resources\Withdrawals\WithdrawalResource;
use App\Models\BankAccount;
use App\Models\Campaign;
use App\Models\CampaignerProfile;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\AdminWithdrawalPendingNotification;
use App\Services\WithdrawalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class WithdrawalServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('pdo_sqlite extension is not available in this environment.');
        }

        parent::setUp();
    }

    public function test_non_verified_user_cannot_view_withdrawal_resource(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user);

        $this->assertFalse(WithdrawalResource::canViewAny());
        $this->assertFalse(BankAccountResource::canViewAny());
    }

    public function test_verified_campaigner_can_create_withdrawal_for_own_campaign_only(): void
    {
        Notification::fake();

        [$campaigner, $campaign] = $this->createVerifiedCampaignerWithCampaign(currentAmount: 150000);
        $otherCampaigner = User::factory()->create([
            'role' => 'user',
        ]);
        CampaignerProfile::create([
            'user_id' => $otherCampaigner->id,
            'no_wa' => '081234567891',
            'wa_verified_at' => now(),
            'email_campaigner' => 'other@example.com',
            'email_verified_at' => now(),
            'nik' => '9876543210123456',
            'foto_ktp' => 'campaigner_docs/other-ktp.jpg',
            'foto_selfie_ktp' => 'campaigner_docs/other-selfie.jpg',
            'status_verifikasi' => 'disetujui',
        ]);

        $service = app(WithdrawalService::class);
        $withdrawal = $service->create($campaigner, $campaign);

        $this->assertDatabaseHas('withdrawals', [
            'id' => $withdrawal->id,
            'user_id' => $campaigner->id,
            'campaign_id' => $campaign->id,
            'status' => Withdrawal::STATUS_PENDING,
            'amount' => 150000,
        ]);

        $this->assertSame('BCA', $withdrawal->bank_name_snapshot);
        $this->assertSame('1234567890', $withdrawal->account_number_snapshot);
        $this->assertSame('Campaigner Satu', $withdrawal->account_holder_snapshot);

        $foreignCampaign = Campaign::create([
            'user_id' => $otherCampaigner->id,
            'category_id' => $campaign->category_id,
            'title' => 'Campaign Milik Orang Lain',
            'slug' => 'campaign-milik-orang-lain',
            'description' => 'Desc',
            'image' => 'campaigns/test.jpg',
            'target_amount' => 200000,
            'current_amount' => 100000,
            'end_date' => now()->addDays(10)->toDateString(),
            'status' => Campaign::STATUS_ACTIVE,
        ]);

        $this->expectException(ValidationException::class);
        $service->create($campaigner, $foreignCampaign);
    }

    public function test_admin_cannot_create_withdrawal_for_own_campaign_and_cannot_open_bank_account_resource(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $categoryId = DB::table('disaster_categories')->insertGetId([
            'name' => 'Longsor',
            'slug' => 'longsor-admin',
            'icon' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $campaign = Campaign::create([
            'user_id' => $admin->id,
            'category_id' => $categoryId,
            'title' => 'Campaign Admin',
            'slug' => 'campaign-admin',
            'description' => 'Campaign milik admin.',
            'image' => 'campaigns/admin.jpg',
            'target_amount' => 300000,
            'current_amount' => 200000,
            'end_date' => now()->addDays(5)->toDateString(),
            'status' => Campaign::STATUS_ACTIVE,
        ]);

        BankAccount::create([
            'user_id' => $admin->id,
            'nama_bank' => 'MANDIRI',
            'nomor_rekening' => '9988776655',
            'nama_pemilik' => 'Admin AkuPeduli',
        ]);

        $this->actingAs($admin);
        $this->assertFalse(BankAccountResource::canViewAny());

        $this->expectException(ValidationException::class);
        app(WithdrawalService::class)->create($admin, $campaign);
    }

    public function test_admin_sees_all_withdrawals_while_campaigner_only_sees_own_records(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        [$campaignerOne, $campaignOne] = $this->createVerifiedCampaignerWithCampaign(currentAmount: 100000);
        [$campaignerTwo, $campaignTwo] = $this->createVerifiedCampaignerWithCampaign(currentAmount: 200000);

        $service = app(WithdrawalService::class);
        $withdrawalOne = $service->create($campaignerOne, $campaignOne);
        $withdrawalTwo = $service->create($campaignerTwo, $campaignTwo);

        $this->actingAs($admin);
        $this->assertSameCanonicalizing(
            [$withdrawalOne->id, $withdrawalTwo->id],
            WithdrawalResource::getEloquentQuery()->pluck('id')->all(),
        );

        $this->actingAs($campaignerOne);
        $this->assertSame([$withdrawalOne->id], WithdrawalResource::getEloquentQuery()->pluck('id')->all());
    }

    public function test_withdrawal_requires_positive_balance_and_no_existing_pending_request(): void
    {
        [$campaigner, $campaign] = $this->createVerifiedCampaignerWithCampaign(currentAmount: 100000);
        $service = app(WithdrawalService::class);

        $service->create($campaigner, $campaign);

        try {
            $service->create($campaigner, $campaign);
            $this->fail('Expected ValidationException for duplicate pending withdrawal.');
        } catch (ValidationException $exception) {
            $this->assertStringContainsString('pending', collect($exception->errors())->flatten()->join(' '));
        }

        $campaignWithoutBalance = Campaign::create([
            'user_id' => $campaigner->id,
            'category_id' => $campaign->category_id,
            'title' => 'Campaign Tanpa Saldo',
            'slug' => 'campaign-tanpa-saldo',
            'description' => 'Desc',
            'image' => 'campaigns/test2.jpg',
            'target_amount' => 100000,
            'current_amount' => 0,
            'end_date' => now()->addDays(7)->toDateString(),
            'status' => Campaign::STATUS_ACTIVE,
        ]);

        $this->expectException(ValidationException::class);
        $service->create($campaigner, $campaignWithoutBalance);
    }

    public function test_admin_can_approve_and_reduce_campaign_balance(): void
    {
        [$campaigner, $campaign] = $this->createVerifiedCampaignerWithCampaign(currentAmount: 250000);
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $withdrawal = app(WithdrawalService::class)->create($campaigner, $campaign);

        app(WithdrawalService::class)->approveAndTransfer($withdrawal, $admin);

        $this->assertDatabaseHas('withdrawals', [
            'id' => $withdrawal->id,
            'status' => Withdrawal::STATUS_TRANSFERRED,
            'approved_by' => $admin->id,
        ]);
        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'current_amount' => 0,
        ]);
    }

    public function test_admin_can_reject_without_changing_campaign_balance(): void
    {
        [$campaigner, $campaign] = $this->createVerifiedCampaignerWithCampaign(currentAmount: 180000);
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $withdrawal = app(WithdrawalService::class)->create($campaigner, $campaign);

        app(WithdrawalService::class)->reject($withdrawal, $admin, 'Dokumen transfer belum valid.');

        $this->assertDatabaseHas('withdrawals', [
            'id' => $withdrawal->id,
            'status' => Withdrawal::STATUS_REJECTED,
            'rejected_by' => $admin->id,
            'rejection_reason' => 'Dokumen transfer belum valid.',
        ]);
        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'current_amount' => 180000,
        ]);
    }

    public function test_approve_fails_if_withdrawal_is_not_pending_or_balance_is_insufficient(): void
    {
        [$campaigner, $campaign] = $this->createVerifiedCampaignerWithCampaign(currentAmount: 120000);
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $service = app(WithdrawalService::class);
        $withdrawal = $service->create($campaigner, $campaign);

        $withdrawal->update([
            'status' => Withdrawal::STATUS_REJECTED,
            'rejected_by' => $admin->id,
            'rejection_reason' => 'Test',
        ]);

        try {
            $service->approveAndTransfer($withdrawal, $admin);
            $this->fail('Expected ValidationException when approving non-pending withdrawal.');
        } catch (ValidationException $exception) {
            $this->assertStringContainsString('pending', collect($exception->errors())->flatten()->join(' '));
        }

        $withdrawal = $service->create($campaigner, $campaign->fresh());
        $campaign->update([
            'current_amount' => 1000,
        ]);

        $this->expectException(ValidationException::class);
        $service->approveAndTransfer($withdrawal, $admin);
    }

    public function test_admin_notification_is_sent_when_withdrawal_is_created(): void
    {
        Notification::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        [$campaigner, $campaign] = $this->createVerifiedCampaignerWithCampaign(currentAmount: 175000);

        app(WithdrawalService::class)->create($campaigner, $campaign);

        Notification::assertSentTo($admin, AdminWithdrawalPendingNotification::class);
    }

    public function test_bank_account_resource_is_available_for_verified_campaigner_only(): void
    {
        [$campaigner] = $this->createVerifiedCampaignerWithCampaign(currentAmount: 90000);

        $this->actingAs($campaigner);
        $this->assertTrue(BankAccountResource::canViewAny());
        $this->assertFalse(BankAccountResource::canCreate());
    }

    public function test_updated_bank_account_is_used_for_new_withdrawal_snapshot_without_changing_old_withdrawal(): void
    {
        [$campaigner, $campaignOne] = $this->createVerifiedCampaignerWithCampaign(currentAmount: 110000);
        $service = app(WithdrawalService::class);

        $firstWithdrawal = $service->create($campaigner, $campaignOne);
        $service->reject($firstWithdrawal, User::factory()->create(['role' => 'admin']), 'Ganti rekening dulu.');

        $bankAccount = $campaigner->bankAccounts()->firstOrFail();
        $bankAccount->update([
            'nama_bank' => 'BNI',
            'nomor_rekening' => '555666777',
            'nama_pemilik' => 'Campaigner Baru',
        ]);

        $categoryId = DB::table('disaster_categories')->insertGetId([
            'name' => 'Gempa',
            'slug' => 'gempa-'.$campaigner->id,
            'icon' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $campaignTwo = Campaign::create([
            'user_id' => $campaigner->id,
            'category_id' => $categoryId,
            'title' => 'Campaign Kedua',
            'slug' => 'campaign-kedua-'.$campaigner->id,
            'description' => 'Campaign kedua untuk test rekening.',
            'image' => 'campaigns/test-second.jpg',
            'target_amount' => 400000,
            'current_amount' => 125000,
            'end_date' => now()->addDays(12)->toDateString(),
            'status' => Campaign::STATUS_ACTIVE,
        ]);

        $secondWithdrawal = $service->create($campaigner, $campaignTwo);

        $this->assertSame('BCA', $firstWithdrawal->fresh()->bank_name_snapshot);
        $this->assertSame('1234567890', $firstWithdrawal->fresh()->account_number_snapshot);
        $this->assertSame('Campaigner Satu', $firstWithdrawal->fresh()->account_holder_snapshot);

        $this->assertSame('BNI', $secondWithdrawal->bank_name_snapshot);
        $this->assertSame('555666777', $secondWithdrawal->account_number_snapshot);
        $this->assertSame('Campaigner Baru', $secondWithdrawal->account_holder_snapshot);

        $this->assertSame('disetujui', $campaigner->campaignerProfile()->firstOrFail()->status_verifikasi);
    }

    private function createVerifiedCampaignerWithCampaign(int $currentAmount): array
    {
        $campaigner = User::factory()->create([
            'role' => 'user',
        ]);

        CampaignerProfile::create([
            'user_id' => $campaigner->id,
            // 👇 Gunakan fake() agar selalu unik setiap kali fungsi ini dipanggil
            'no_wa' => fake()->unique()->numerify('08##########'),
            'wa_verified_at' => now(),
            'email_campaigner' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'nik' => fake()->unique()->numerify('################'), // 👈 Ini kunci utamanya (16 digit acak)
            'foto_ktp' => 'campaigner_docs/ktp.jpg',
            'foto_selfie_ktp' => 'campaigner_docs/selfie.jpg',
            'status_verifikasi' => 'disetujui',
        ]);

        BankAccount::create([
            'user_id' => $campaigner->id,
            'nama_bank' => 'BCA',
            'nomor_rekening' => fake()->numerify('##########'), // Acak juga nomor rekeningnya
            'nama_pemilik' => 'Campaigner ' . $campaigner->id, // Tambahkan ID agar unik
        ]);

        $categoryId = DB::table('disaster_categories')->insertGetId([
            'name' => 'Banjir',
            'slug' => 'banjir-'.$campaigner->id.'-'.$currentAmount,
            'icon' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $campaign = Campaign::create([
            'user_id' => $campaigner->id,
            'category_id' => $categoryId,
            'title' => 'Campaign Pencairan',
            'slug' => 'campaign-pencairan-'.$campaigner->id.'-'.$currentAmount,
            'description' => 'Deskripsi campaign untuk test.',
            'image' => 'campaigns/test.jpg',
            'target_amount' => 500000,
            'current_amount' => $currentAmount,
            'end_date' => now()->addDays(14)->toDateString(),
            'status' => Campaign::STATUS_ACTIVE,
        ]);

        return [$campaigner, $campaign];
    }
}
