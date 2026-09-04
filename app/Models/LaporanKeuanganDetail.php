<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanKeuanganDetail extends Model
{
    use SoftDeletes;

    protected $table = 'laporan_keuangan_details';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'TahunPeriode' => 'date',
        'JumlahDownload' => 'integer',
        'Urutan' => 'integer',
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisLaporanKeuangan::class, 'JenisLaporanId');
    }
}
