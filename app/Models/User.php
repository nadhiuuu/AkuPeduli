<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto_profil',
        'role',
        'verify_key',
    ];

    /**
     * Kolom yang harus disembunyikan saat serialisasi (JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Kontrol Akses Panel Filament.
     * Fungsi ini menentukan siapa saja yang boleh masuk ke dashboard.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Panel Admin hanya bisa diakses oleh role 'admin'
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        // Panel User bisa diakses oleh role 'user' maupun 'admin'
        if ($panel->getId() === 'user') {
            return in_array($this->role, ['admin', 'user']);
        }

        return false;
    }

    /**
     * Relasi ke Profil Pembuat Kampanye (KYC).
     * Satu user memiliki satu profil verifikasi (1-to-1).
     */
    public function campaignerProfile(): HasOne
    {
        return $this->hasOne(CampaignerProfile::class);
    }

    /**
     * Relasi ke Rekening Bank.
     * Satu user bisa memiliki banyak rekening (1-to-Many).
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    public function campaigns() { 
        return $this->hasMany(Campaign::class); 
    }

    public function donations() { 
        return $this->hasMany(Donation::class); 
    }

    /**
     * Helper: Mengecek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Helper: Mendapatkan URL foto profil.
     */
    public function getFotoProfilUrlAttribute(): string
    {
        return $this->foto_profil 
            ? asset('storage/' . $this->foto_profil) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }
}