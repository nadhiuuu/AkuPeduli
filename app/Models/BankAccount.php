<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik',
        'is_utama',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected $casts = [
        'is_utama' => 'boolean',
    ];

    /**
     * Relasi balik ke User (Inverse Relationship).
     * Rekening ini dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}