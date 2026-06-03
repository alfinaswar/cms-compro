<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PengaturanWebsite extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengaturan_websites';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'ModeMaintenance' => 'boolean',
        'AktifkanCookieConsent' => 'boolean',
    ];

    /**
     * Ambil value setting dengan caching (1 jam)
     */
    public static function get($key, $default = null)
    {
        return Cache::remember('pengaturan_website', 3600, function () use ($key, $default) {
            $settings = self::first();
            return $settings?->{$key} ?? $default;
        });
    }

    /**
     * Hapus cache saat ada perubahan data
     */
    public static function clearCache()
    {
        Cache::forget('pengaturan_website');
    }

    /**
     * Helper untuk mendapatkan URL file dari storage disk public
     */
    public static function getFilePath($path)
    {
        if (!$path || !Storage::disk('public')->exists($path)) {
            return null;
        }
        return Storage::disk('public')->url($path);
    }
}
