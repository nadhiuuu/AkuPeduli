<?php

namespace App\Support;

class JemberRegion
{
    protected static ?array $districtCenterCache = null;

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

    public static function districtCoordinates(?string $district): ?array
    {
        $district = static::canonicalDistrictName($district);

        if (! $district) {
            return null;
        }

        return static::districtCenters()[$district] ?? null;
    }

    public static function villageCoordinates(?string $district, ?string $village): ?array
    {
        $district = static::canonicalDistrictName($district);

        if (! $district || ! static::isValidVillage($district, $village)) {
            return null;
        }

        return static::districtCoordinates($district);
    }

    public static function coordinatesForSelection(?string $district, ?string $village): ?array
    {
        if (! filled($village)) {
            return null;
        }

        return static::villageCoordinates($district, $village);
    }

    protected static function districtCenters(): array
    {
        if (static::$districtCenterCache !== null) {
            return static::$districtCenterCache;
        }

        $geoJsonPath = static::districtGeoJsonPath();

        if (! is_file($geoJsonPath)) {
            return static::$districtCenterCache = [];
        }

        $payload = json_decode((string) file_get_contents($geoJsonPath), true);

        if (! is_array($payload['features'] ?? null)) {
            return static::$districtCenterCache = [];
        }

        $centers = [];

        foreach ($payload['features'] as $feature) {
            $district = static::canonicalDistrictName($feature['properties']['nm_kecamatan'] ?? null);
            $coordinates = $feature['geometry']['coordinates'] ?? null;

            if (! $district || ! is_array($coordinates)) {
                continue;
            }

            $bounds = static::extractBounds($coordinates);

            if (! $bounds) {
                continue;
            }

            $centers[$district] = [
                'lat' => round(($bounds['minLat'] + $bounds['maxLat']) / 2, 6),
                'lng' => round(($bounds['minLng'] + $bounds['maxLng']) / 2, 6),
            ];
        }

        return static::$districtCenterCache = $centers;
    }

    protected static function districtGeoJsonPath(): string
    {
        return dirname(__DIR__, 2).'/public/data/jember-kecamatan.geojson';
    }

    protected static function extractBounds(array $coordinates): ?array
    {
        $bounds = [
            'minLat' => null,
            'maxLat' => null,
            'minLng' => null,
            'maxLng' => null,
        ];

        static::walkCoordinates($coordinates, function (float $lng, float $lat) use (&$bounds): void {
            $bounds['minLat'] = $bounds['minLat'] === null ? $lat : min($bounds['minLat'], $lat);
            $bounds['maxLat'] = $bounds['maxLat'] === null ? $lat : max($bounds['maxLat'], $lat);
            $bounds['minLng'] = $bounds['minLng'] === null ? $lng : min($bounds['minLng'], $lng);
            $bounds['maxLng'] = $bounds['maxLng'] === null ? $lng : max($bounds['maxLng'], $lng);
        });

        if (in_array(null, $bounds, true)) {
            return null;
        }

        return $bounds;
    }

    protected static function walkCoordinates(array $coordinates, callable $callback): void
    {
        if (
            isset($coordinates[0], $coordinates[1]) &&
            is_numeric($coordinates[0]) &&
            is_numeric($coordinates[1])
        ) {
            $callback((float) $coordinates[0], (float) $coordinates[1]);

            return;
        }

        foreach ($coordinates as $nestedCoordinates) {
            if (is_array($nestedCoordinates)) {
                static::walkCoordinates($nestedCoordinates, $callback);
            }
        }
    }
}
