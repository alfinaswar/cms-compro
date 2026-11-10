<?php

namespace App\Support;

class IconHelper
{
    /**
     * Cek apakah nilai icon merupakan class FontAwesome (FA4/FA5/FA6) dan bukan path gambar storage.
     */
    public static function isFontAwesome(?string $value): bool
    {
        $value = trim((string) $value);
        if ($value === '' || str_contains($value, '/') || preg_match('/\.(png|jpe?g|svg|webp|gif|ico)(\?.*)?$/i', $value)) {
            return false;
        }

        return (bool) preg_match(
            '/^(?:fa[srbltd]?|fa-(?:solid|regular|brands|light|thin|duotone))\s+fa-[a-z0-9-]+|^fa-[a-z0-9-]+/i',
            $value
        );
    }

    /**
     * Rapikan spasi dan karakter class CSS dari input icon.
     */
    public static function sanitizeClass(?string $value): ?string
    {
        $raw = trim((string) $value);
        if ($raw === '' || str_contains($raw, '/') || str_contains($raw, '.')) {
            return null;
        }

        $clean = preg_replace('/[^a-zA-Z0-9\s_-]/', '', $raw);
        $clean = preg_replace('/\s+/', ' ', trim((string) $clean));

        return self::isFontAwesome($clean) ? $clean : null;
    }
}
