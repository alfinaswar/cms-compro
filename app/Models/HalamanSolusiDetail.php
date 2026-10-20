<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HalamanSolusiDetail extends Model
{
    use SoftDeletes;

    protected $table = 'halaman_solusi_details';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Relasi ke tabel terjemahan detail
     */
    public function translations()
    {
        return $this->hasMany(HalamanSolusiDetailTranslation::class, 'halaman_solusi_detail_id');
    }

    /**
     * Helper untuk mengambil terjemahan detail berdasarkan bahasa
     */
    public function translate($locale = 'id')
    {
        return $this->translations->firstWhere('Locale', $locale) ?: new HalamanSolusiDetailTranslation();
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
     * Relasi balik ke model utama solusi
     */
    public function solusi()
    {
        return $this->belongsTo(HalamanSolusi::class, 'HalamanSolusiId');
    }

    /**
     * Relasi 1:1 ke sub-halaman (konten detail subhalaman)
     */
    public function subpage()
    {
        return $this->hasOne(HalamanSolusiSubpage::class, 'HalamanSolusiDetailId', 'id');
    }
}
