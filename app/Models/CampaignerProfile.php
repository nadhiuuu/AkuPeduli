<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'no_wa',
        'wa_verified_at',
        'email_campaigner',
        'email_verified_at',
        'nik',
        'foto_ktp',
        'foto_selfie_ktp',
        'status_verifikasi',
        'alasan_penolakan',
    ];

    protected $casts = [
        'wa_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper: Cek apakah kedua OTP sudah beres
    public function isContactVerified(): bool
    {
        return !is_null($this->wa_verified_at) && !is_null($this->email_verified_at);
    }

    // Helper: Cek apakah admin sudah menyetujui KTP & Bank
    public function isApprovedByAdmin(): bool
    {
        return $this->status_verifikasi === 'disetujui';
    }
}