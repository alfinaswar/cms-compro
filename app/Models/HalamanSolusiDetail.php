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
     * Relasi balik ke model utama solusi
     */
    public function solusi()
    {
        return $this->belongsTo(HalamanSolusi::class, 'HalamanSolusiId');
    }
}
