<?php

namespace App\Support;

class DisasterSeverityResolver
{
    public const LOCAL = 'insiden_lokal';
    public const SIAGA = 'siaga';
    public const MENENGAH = 'menengah';
    public const KRITIS = 'kritis';

    public const COLORS = [
        self::LOCAL => '#9ca3af',
        self::SIAGA => '#facc15',
        self::MENENGAH => '#f97316',
        self::KRITIS => '#ef4444',
    ];

    public const RANKS = [
        self::LOCAL => 0,
        self::SIAGA => 1,
        self::MENENGAH => 2,
        self::KRITIS => 3,
    ];

    public static function resolve(array $data): array
    {
        $jumlahKorban = max(0, (int) ($data['jumlah_korban'] ?? 0));
        $jumlahTerdampak = max(0, (int) ($data['jumlah_terdampak'] ?? 0));
        $rumahRusak = max(0, (int) ($data['rumah_rusak'] ?? 0));
        $fasilitasVitalLumpuh = (bool) ($data['fasilitas_vital_lumpuh'] ?? false);

        $eligibleForCampaign = $jumlahKorban >= 1 || $jumlahTerdampak >= 50 || $rumahRusak >= 5 || $fasilitasVitalLumpuh;

        if (
            $jumlahKorban > 10 ||
            $jumlahTerdampak > 500 ||
            $rumahRusak > 50 ||
            $fasilitasVitalLumpuh
        ) {
            $status = self::KRITIS;
        } elseif (! $eligibleForCampaign) {
            $status = self::LOCAL;
        } elseif (
            ($jumlahKorban >= 1 && $jumlahKorban <= 10) ||
            ($jumlahTerdampak >= 50 && $jumlahTerdampak <= 500) ||
            ($rumahRusak >= 5 && $rumahRusak <= 50)
        ) {
            $status = self::MENENGAH;
        } else {
            $status = self::SIAGA;
        }

        return [
            'status_bencana' => $status,
            'tingkat_keparahan' => $status,
            'eligible_for_campaign' => $eligibleForCampaign,
            'severity_rank' => static::rankFor($status),
            'severity_color' => static::colorFor($status),
            'severity_label' => static::labelFor($status),
        ];
    }

    public static function rankFor(?string $status): int
    {
        return static::RANKS[$status] ?? 0;
    }

    public static function colorFor(?string $status): string
    {
        return static::COLORS[$status] ?? static::COLORS[self::LOCAL];
    }

    public static function labelFor(?string $status): string
    {
        return match ($status) {
            self::SIAGA => 'Siaga',
            self::MENENGAH => 'Menengah',
            self::KRITIS => 'Kritis',
            default => 'Insiden Lokal',
        };
    }

    public static function options(): array
    {
        return [
            self::LOCAL => static::labelFor(self::LOCAL),
            self::SIAGA => static::labelFor(self::SIAGA),
            self::MENENGAH => static::labelFor(self::MENENGAH),
            self::KRITIS => static::labelFor(self::KRITIS),
        ];
    }
}
