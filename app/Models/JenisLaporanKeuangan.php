<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JenisLaporanKeuangan extends Model
{
    use SoftDeletes;

    protected $table = 'jenis_laporan_keuangan';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = ['Urutan' => 'integer'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            if (empty($item->Slug)) {
                $item->Slug = Str::slug($item->NamaJenis);
            }
        });
    }

    public function details()
    {
        return $this->hasMany(LaporanKeuanganDetail::class, 'JenisLaporanId')
            ->where('Status', 'Aktif')
            ->orderBy('Urutan');
    }

    public function allDetails()
    {
        return $this->hasMany(LaporanKeuanganDetail::class, 'JenisLaporanId')
            ->orderBy('Urutan');
    }
}
