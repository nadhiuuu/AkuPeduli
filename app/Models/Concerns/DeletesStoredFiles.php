<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait DeletesStoredFiles
{
    public static function deleteStoredFile(?string $path): void
    {
        if (blank($path)) {
            return;
        }

        $normalizedPath = static::normalizeStoredFilePath($path);

        if (blank($normalizedPath)) {
            return;
        }

        Storage::disk('public')->delete($normalizedPath);

        $publicPath = public_path($normalizedPath);

        if (is_file($publicPath)) {
            @unlink($publicPath);
        }
    }

    protected static function normalizeStoredFilePath(string $path): string
    {
        $normalizedPath = trim($path);

        if (blank($normalizedPath)) {
            return '';
        }

        if (filter_var($normalizedPath, FILTER_VALIDATE_URL)) {
            $normalizedPath = parse_url($normalizedPath, PHP_URL_PATH) ?: '';
        }

        $normalizedPath = str_replace('\\', '/', $normalizedPath);
        $normalizedPath = preg_replace('#^/?storage/#', '', $normalizedPath) ?? $normalizedPath;
        $normalizedPath = ltrim($normalizedPath, '/');

        if (filled($appUrl = config('app.url'))) {
            $normalizedAppUrl = rtrim($appUrl, '/');

            if (Str::startsWith($path, $normalizedAppUrl)) {
                $normalizedPath = ltrim(Str::after($path, $normalizedAppUrl), '/');
                $normalizedPath = preg_replace('#^storage/#', '', $normalizedPath) ?? $normalizedPath;
            }
        }

        return $normalizedPath;
    }
}
