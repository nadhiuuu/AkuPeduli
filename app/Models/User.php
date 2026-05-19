<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Concerns\DeletesStoredFiles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use DeletesStoredFiles;
    use HasFactory, Notifiable;

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'google_id',
        'avatar',
        'password',
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

    protected static function booted(): void
    {
        static::updating(function (self $user): void {
            if (! $user->isDirty('avatar')) {
                return;
            }

            $oldAvatar = $user->getOriginal('avatar');
            $newAvatar = $user->avatar;

            if ($oldAvatar && $oldAvatar !== $newAvatar) {
                static::deleteStoredFile($oldAvatar);
            }
        });

        static::deleting(function (self $user): void {
            if ($user->avatar) {
                static::deleteStoredFile($user->avatar);
            }
        });
    }

    /**
     * Kontrol Akses Panel Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // if ($panel->getId() === 'admin') {
        //     if ($this->role === 'admin') {
        //         return true;
        //     }
            
        //     if ($this->role === 'user' && $this->campaignerProfile && $this->campaignerProfile->isApprovedByAdmin()) {
        //         return true;
        //     }
        // }

        return true;
    }

    public function canAccessDashboard(): bool
    {
        if ($this->role === 'admin') return true;
        return $this->role === 'user' && $this->campaignerProfile && $this->campaignerProfile->isApprovedByAdmin();
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

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
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
