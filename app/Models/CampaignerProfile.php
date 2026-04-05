<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignerProfile extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'nik',
        'foto_ktp',
        'status_verifikasi',
        'alasan_penolakan',
    ];

    /**
     * Relasi balik ke User (Inverse Relationship).
     * Profil ini dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper: Mengecek apakah profil sudah disetujui admin.
     */
    public function isApproved(): bool
    {
        return $this->status_verifikasi === 'disetujui';
    }
}