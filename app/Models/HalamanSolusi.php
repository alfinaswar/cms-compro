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
     * Relasi ke detail solusi
     */
    public function details()
    {
        return $this->hasMany(HalamanSolusidetail::class, 'HalamanSolusiId');
    }
}
