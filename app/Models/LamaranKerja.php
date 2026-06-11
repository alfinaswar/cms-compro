<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class LamaranKerja extends Model
{
    protected $table = 'lamaran_kerja';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    // Relasi ke LowonganKerja
    public function getLowongan(): BelongsTo
    {
        return $this->belongsTo(LowonganKerja::class, 'LowonganKerjaId');
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->Status) {
            'Diterima' => '<span class="badge bg-success">Diterima</span>',
            'Ditolak' => '<span class="badge bg-danger">Ditolak</span>',
            default => '<span class="badge bg-warning text-dark">Menunggu</span>',
        };
    }
}
