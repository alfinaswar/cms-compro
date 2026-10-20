<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HalamanSolusiSubpageItem extends Model
{
    use SoftDeletes;

    protected $table = 'halaman_solusi_subpage_items';

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
        'Items' => 'array',
    ];

    /**
     * Relasi ke sub-halaman pemilik item ini
     */
    public function subpage()
    {
        return $this->belongsTo(HalamanSolusiSubpage::class, 'HalamanSolusiSubpageId');
    }

    /**
     * Relasi ke tabel terjemahan item
     */
    public function translations()
    {
        return $this->hasMany(HalamanSolusiSubpageItemTranslation::class, 'HalamanSolusiSubpageItemId');
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

        return $trans ?: new HalamanSolusiSubpageItemTranslation();
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
}
