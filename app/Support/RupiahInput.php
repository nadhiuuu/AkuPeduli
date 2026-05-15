<?php

namespace App\Support;

class RupiahInput
{
    public static function format(mixed $value): string
    {
        $normalized = static::normalizeDigits($value);

        if ($normalized === '') {
            return '';
        }

        return number_format((int) $normalized, 0, ',', '.');
    }

    public static function normalize(mixed $value): ?int
    {
        $normalized = static::normalizeDigits($value);

        if ($normalized === '') {
            return null;
        }

        return (int) $normalized;
    }

    private static function normalizeDigits(mixed $value): string
    {
        if ($value === null) {
            return '';
        }

        return preg_replace('/\D+/', '', (string) $value) ?? '';
    }
}
