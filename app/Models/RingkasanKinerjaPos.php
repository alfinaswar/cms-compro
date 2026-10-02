<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RingkasanKinerjaPos extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'ringkasan_kinerja_pos';
    protected $guarded = ['id'];

    protected $casts = [
        'IsSubPos' => 'boolean',
        'IsBold' => 'boolean',
        'IsHighlight' => 'boolean',
        'Urutan' => 'integer',
    ];

    public function nilais()
    {
        return $this->hasMany(RingkasanKinerjaNilai::class, 'PosId');
    }

    public function nilaiTahun($tahun)
    {
        return $this->nilais->firstWhere('Tahun', $tahun)?->NilaiTampil ?? '-';
    }

    public function nilaiAngkaTahun($tahun)
    {
        return $this->nilais->firstWhere('Tahun', $tahun)?->NilaiAngka ?? 0;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }
}
