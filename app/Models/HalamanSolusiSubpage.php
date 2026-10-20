<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HalamanSolusiSubpage extends Model
{
    use SoftDeletes;

    protected $table = 'halaman_solusi_subpages';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'IsPublished' => 'boolean',
    ];

    /**
     * Relasi ke detail solusi (pemilik sub-halaman ini)
     */
    public function detail()
    {
        return $this->belongsTo(HalamanSolusiDetail::class, 'HalamanSolusiDetailId', 'id');
    }

    /**
     * Relasi ke halaman solusi induk
     */
    public function solusi()
    {
        return $this->hasOneThrough(
            HalamanSolusi::class,
            HalamanSolusiDetail::class,
            'id',
            'id',
            'HalamanSolusiDetailId',
            'HalamanSolusiId'
        );
    }

    /**
     * Relasi ke item repeater sub-halaman
     */
    public function items()
    {
        return $this->hasMany(HalamanSolusiSubpageItem::class, 'HalamanSolusiSubpageId')->orderBy('SortOrder');
    }

    /**
     * Relasi ke tabel terjemahan sub-halaman
     */
    public function translations()
    {
        return $this->hasMany(HalamanSolusiSubpageTranslation::class, 'HalamanSolusiSubpageId');
    }

    /**
     * Ambil terjemahan berdasarkan bahasa: locale aktif -> terjemahan 'id' -> objek kosong
     */
    public function translate($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $trans = $this->translations->firstWhere('Locale', $locale);

        // Fallback ke terjemahan Indonesia jika bahasa diminta tidak tersedia
        if (!$trans && $locale !== 'id') {
            $trans = $this->translations->firstWhere('Locale', 'id');
        }

        return $trans ?: new HalamanSolusiSubpageTranslation();
    }

    /**
     * Nilai field sesuai bahasa dengan fallback ke kolom utama (berisi konten Indonesia)
     */
    public function t($field, $locale = null)
    {
        $value = $this->translate($locale)->{$field} ?? null;

        if ($value === null || $value === '') {
            return $this->{$field} ?? null;
        }

        return $value;
    }

    /**
     * Ambil item berdasarkan section (section1 | section2 | section3 | faq)
     */
    public function itemsBySection($section)
    {
        return $this->items->where('Section', $section)->values();
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
