<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LowonganKerjaTranslation extends Model
{
    protected $table = 'lowongan_kerja_translations';

    // Matikan timestamp jika tidak diperlukan di tabel terjemahan,
    // atau biarkan jika kamu membuatnya di migration.
    public $timestamps = true;

    protected $fillable = [
        'LowonganKerjaId',
        'Locale',
        'Posisi',
        'Deskripsi',
        'Kualifikasi'
    ];

    public function lowongan()
    {
        return $this->belongsTo(LowonganKerja::class, 'LowonganKerjaId');
    }
}
