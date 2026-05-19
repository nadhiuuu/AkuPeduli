<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\AdminWithdrawalPendingNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WithdrawalService
{
    public function create(User $user, Campaign $campaign): Withdrawal
    {
        if ($user->isAdmin() || ! $user->canAccessDashboard()) {
            throw ValidationException::withMessages([
                'campaign_id' => 'Hanya campaigner terverifikasi yang dapat mengajukan pencairan.',
            ]);
        }

        if ((int) $campaign->user_id !== (int) $user->id) {
            throw ValidationException::withMessages([
                'campaign_id' => 'Anda hanya dapat mengajukan pencairan untuk campaign milik sendiri.',
            ]);
        }

        $bankAccount = $user->bankAccounts()->first();

        if (! $bankAccount) {
            throw ValidationException::withMessages([
                'campaign_id' => 'Rekening bank belum tersedia untuk pencairan.',
            ]);
        }

        $withdrawal = DB::transaction(function () use ($user, $campaign, $bankAccount): Withdrawal {
            $lockedCampaign = Campaign::query()
                ->lockForUpdate()
                ->findOrFail($campaign->id);

            if ((float) $lockedCampaign->current_amount <= 0) {
                throw ValidationException::withMessages([
                    'campaign_id' => 'Campaign ini belum memiliki saldo untuk dicairkan.',
                ]);
            }

            if ($lockedCampaign->withdrawals()->where('status', Withdrawal::STATUS_PENDING)->exists()) {
                throw ValidationException::withMessages([
                    'campaign_id' => 'Campaign ini masih memiliki pengajuan pencairan yang pending.',
                ]);
            }

            return Withdrawal::create([
                'user_id' => $user->id,
                'campaign_id' => $lockedCampaign->id,
                'bank_account_id' => $bankAccount->id,
                'amount' => $lockedCampaign->current_amount,
                'status' => Withdrawal::STATUS_PENDING,
                'requested_at' => now(),
                'bank_name_snapshot' => $bankAccount->nama_bank,
                'account_number_snapshot' => $bankAccount->nomor_rekening,
                'account_holder_snapshot' => $bankAccount->nama_pemilik,
            ]);
        });

        User::query()
            ->where('role', 'admin')
            ->get()
            ->each(fn (User $admin) => $admin->notify(new AdminWithdrawalPendingNotification($withdrawal->load(['campaign', 'user']))));

        return $withdrawal;
    }

    public function approveAndTransfer(Withdrawal $withdrawal, User $admin): Withdrawal
    {
        if (! $admin->isAdmin()) {
            throw ValidationException::withMessages([
                'withdrawal' => 'Hanya admin yang dapat menyetujui pencairan.',
            ]);
        }

        return DB::transaction(function () use ($withdrawal, $admin): Withdrawal {
            $lockedWithdrawal = Withdrawal::query()
                ->lockForUpdate()
                ->with('campaign')
                ->findOrFail($withdrawal->id);

            if ($lockedWithdrawal->status !== Withdrawal::STATUS_PENDING) {
                throw ValidationException::withMessages([
                    'withdrawal' => 'Pengajuan ini tidak lagi berstatus pending.',
                ]);
            }

            $campaign = Campaign::query()
                ->lockForUpdate()
                ->findOrFail($lockedWithdrawal->campaign_id);

            if ((float) $campaign->current_amount < (float) $lockedWithdrawal->amount) {
                throw ValidationException::withMessages([
                    'withdrawal' => 'Saldo campaign saat ini tidak mencukupi untuk pencairan ini.',
                ]);
            }

            $lockedWithdrawal->update([
                'status' => Withdrawal::STATUS_TRANSFERRED,
                'transferred_at' => now(),
                'approved_by' => $admin->id,
                'rejected_by' => null,
                'rejection_reason' => null,
            ]);

            $campaign->update([
                'current_amount' => round((float) $campaign->current_amount - (float) $lockedWithdrawal->amount, 2),
            ]);

            return $lockedWithdrawal->fresh(['campaign', 'user', 'bankAccount', 'approver']);
        });
    }

    public function reject(Withdrawal $withdrawal, User $admin, string $reason): Withdrawal
    {
        if (! $admin->isAdmin()) {
            throw ValidationException::withMessages([
                'withdrawal' => 'Hanya admin yang dapat menolak pencairan.',
            ]);
        }

        return DB::transaction(function () use ($withdrawal, $admin, $reason): Withdrawal {
            $lockedWithdrawal = Withdrawal::query()
                ->lockForUpdate()
                ->findOrFail($withdrawal->id);

            if ($lockedWithdrawal->status !== Withdrawal::STATUS_PENDING) {
                throw ValidationException::withMessages([
                    'withdrawal' => 'Pengajuan ini tidak lagi berstatus pending.',
                ]);
            }

            $lockedWithdrawal->update([
                'status' => Withdrawal::STATUS_REJECTED,
                'transferred_at' => null,
                'approved_by' => null,
                'rejected_by' => $admin->id,
                'rejection_reason' => $reason,
            ]);

            return $lockedWithdrawal->fresh(['campaign', 'user', 'bankAccount', 'rejector']);
        });
    }
}
