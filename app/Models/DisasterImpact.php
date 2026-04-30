<?php

namespace App\Models;

use App\Support\DisasterSeverityResolver;
use App\Support\JemberRegion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class DisasterImpact extends Model
{
    protected $fillable = [
        'campaign_id', 
        'latitude', 
        'longitude', 
        'kecamatan', 
        'desa', 
        'jumlah_korban', 
        'jumlah_terdampak',
        'rumah_rusak',
        'fasilitas_vital_lumpuh',
        'kerugian_materil',
        'bukti_surat_bpbd',
        'tingkat_keparahan',
    ];

    protected function casts(): array
    {
        return [
            'fasilitas_vital_lumpuh' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $impact): void {
            if (! JemberRegion::isValidDistrict($impact->kecamatan)) {
                throw ValidationException::withMessages([
                    'kecamatan' => 'Kecamatan yang dipilih tidak valid.',
                ]);
            }

            if (! JemberRegion::isValidVillage($impact->kecamatan, $impact->desa)) {
                throw ValidationException::withMessages([
                    'desa' => 'Desa / kelurahan tidak sesuai dengan kecamatan yang dipilih.',
                ]);
            }

            $resolved = DisasterSeverityResolver::resolve([
                'jumlah_korban' => $impact->jumlah_korban,
                'jumlah_terdampak' => $impact->jumlah_terdampak,
                'rumah_rusak' => $impact->rumah_rusak,
                'fasilitas_vital_lumpuh' => $impact->fasilitas_vital_lumpuh,
            ]);

            $impact->tingkat_keparahan = $resolved['tingkat_keparahan'];
        });
    }

    public function campaign() { 
        return $this->belongsTo(Campaign::class); 
    }
}
