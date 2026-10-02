<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PengaturanKinerjaKeuangan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'pengaturan_kinerja_keuangans';
    protected $guarded = ['id'];

    protected $casts = [
        'JumlahTahun' => 'integer',
        'TahunMulai' => 'integer',
        'TahunSelesai' => 'integer',
    ];

    /**
     * Dapatkan array tahun yang aktif ditampilkan di frontend
     * Misal: [2021, 2022, 2023, 2024, 2025]
     */
    public function getActiveYears(): array
    {
        if ($this->ModeWindow === 'Kustom' && $this->TahunMulai && $this->TahunSelesai && $this->TahunSelesai >= $this->TahunMulai) {
            return range($this->TahunMulai, $this->TahunSelesai);
        }

        // Mode Otomatis: Ambil N tahun terakhir dari database
        $distinctYears = RingkasanKinerjaNilai::distinct()->orderBy('Tahun', 'desc')->pluck('Tahun')->toArray();
        if (!empty($distinctYears)) {
            $slice = array_slice($distinctYears, 0, $this->JumlahTahun ?: 5);
            sort($slice);
            return $slice;
        }

        return [2021, 2022, 2023, 2024, 2025];
    }

    /**
     * Dapatkan semua tahun yang tercatat di database
     */
    public function getAllYears(): array
    {
        $years = RingkasanKinerjaNilai::distinct()->orderBy('Tahun', 'asc')->pluck('Tahun')->toArray();
        if (empty($years)) {
            return [2021, 2022, 2023, 2024, 2025];
        }
        return $years;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }
}
