<?php

namespace App\Models;

use App\Models\Concerns\DeletesStoredFiles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use DeletesStoredFiles;

    public const STATUS_PENDING = 'Menunggu Verifikasi Admin';
    public const STATUS_ACTIVE = 'Aktif / Tayang';
    public const STATUS_REJECTED = 'Ditolak';
    public const STATUS_COMPLETED = 'Selesai';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'image',
        'target_amount',
        'current_amount',
        'end_date',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'submitted_for_review_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
            'submitted_for_review_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::updating(function (self $campaign): void {
            if (! $campaign->isDirty('image')) {
                return;
            }

            $oldImage = $campaign->getOriginal('image');
            $newImage = $campaign->image;

            if ($oldImage && $oldImage !== $newImage) {
                static::deleteStoredFile($oldImage);
            }
        });

        static::deleting(function (self $campaign): void {
            if ($campaign->image) {
                static::deleteStoredFile($campaign->image);
            }
        });
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Menunggu Verifikasi Admin',
            self::STATUS_ACTIVE => 'Aktif / Tayang',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATUS_COMPLETED => 'Selesai',
        ];
    }

    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeOwnedBy(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function isPubliclyVisible(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DisasterCategory::class, 'category_id');
    }

    public function impact()
    {
        return $this->hasOne(DisasterImpact::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function documentations()
    {
        return $this->hasMany(Documentation::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
