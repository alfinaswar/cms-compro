<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HalamanSolusi extends Model
{
    use SoftDeletes;

    protected $table = 'halaman_solusis';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'FaqItems' => 'array',
    ];

    /**
     * Relasi ke tabel terjemahan utama
     */
    public function translations()
    {
        return $this->hasMany(HalamanSolusiTranslation::class, 'halaman_solusi_id');
    }

    /**
     * Helper untuk mengambil terjemahan berdasarkan bahasa
     */
    public function translate($locale = 'id')
    {
        return $this->translations->firstWhere('Locale', $locale) ?: new HalamanSolusiTranslation();
    }

    /**
     * Nilai field sesuai bahasa: terjemahan locale -> terjemahan 'id' -> kolom utama
     */
    public function t($field, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $trans = $this->translations->firstWhere('Locale', $locale);

        // Fallback ke terjemahan Indonesia jika bahasa diminta tidak tersedia
        if (!$trans && $locale !== 'id') {
            $trans = $this->translations->firstWhere('Locale', 'id');
        }

        $value = $trans->{$field} ?? null;

        if ($value === null || $value === '') {
            return $this->{$field} ?? null;
        }

        return $value;
    }

    /**
     * Relasi ke detail solusi
     */
    public function details()
    {
        return $this->hasMany(HalamanSolusiDetail::class, 'HalamanSolusiId');
    }

    protected static function booted(): void
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('halaman_solusi');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('halaman_solusi');
        });
    }
}

