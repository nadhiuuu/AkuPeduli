<?php

namespace App\Support;

class JemberRegion
{
    public static function districts(): array
    {
        if (function_exists('config') && app()->bound('config')) {
            return config('jember_regions', []);
        }

        return require dirname(__DIR__, 2).'/config/jember_regions.php';
    }

    public static function districtOptions(): array
    {
        return collect(static::districts())
            ->keys()
            ->mapWithKeys(fn (string $district): array => [$district => $district])
            ->all();
    }

    public static function villagesForDistrict(?string $district): array
    {
        $district = static::canonicalDistrictName($district);

        if (! $district) {
            return [];
        }

        $villages = static::districts()[$district] ?? [];

        return collect($villages)
            ->mapWithKeys(fn (string $village): array => [$village => $village])
            ->all();
    }

    public static function isValidDistrict(?string $district): bool
    {
        return static::canonicalDistrictName($district) !== null;
    }

    public static function isValidVillage(?string $district, ?string $village): bool
    {
        $district = static::canonicalDistrictName($district);

        if (! $district || ! is_string($village) || $village === '') {
            return false;
        }

        return in_array($village, static::districts()[$district], true);
    }

    public static function canonicalDistrictName(?string $district): ?string
    {
        if (! is_string($district) || $district === '') {
            return null;
        }

        $normalized = static::normalizeDistrictName($district);

        foreach (array_keys(static::districts()) as $candidate) {
            if (static::normalizeDistrictName($candidate) === $normalized) {
                return $candidate;
            }
        }

        return null;
    }

    public static function normalizeDistrictName(?string $district): string
    {
        return static::normalizeName($district);
    }

    public static function normalizeName(?string $value): string
    {
        if (! is_string($value)) {
            return '';
        }

        return str($value)
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/i', ' ')
            ->squish()
            ->value();
    }
}
