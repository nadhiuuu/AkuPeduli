<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_TRANSFERRED = 'transferred';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'campaign_id',
        'bank_account_id',
        'amount',
        'status',
        'requested_at',
        'transferred_at',
        'approved_by',
        'rejected_by',
        'rejection_reason',
        'bank_name_snapshot',
        'account_number_snapshot',
        'account_holder_snapshot',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'requested_at' => 'datetime',
            'transferred_at' => 'datetime',
        ];
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_TRANSFERRED => 'Sudah Ditransfer',
            self::STATUS_REJECTED => 'Ditolak',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
