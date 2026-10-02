<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RingkasanKinerjaNilai extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'ringkasan_kinerja_nilais';
    protected $guarded = ['id'];

    protected $casts = [
        'PosId' => 'integer',
        'Tahun' => 'integer',
        'NilaiAngka' => 'decimal:2',
    ];

    public function pos()
    {
        return $this->belongsTo(RingkasanKinerjaPos::class, 'PosId');
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('NilaiTampil')) {
                $model->NilaiAngka = static::parseToNumeric($model->NilaiTampil);
            }
        });
    }

    public static function parseToNumeric(?string $val): ?float
    {
        if ($val === null || trim($val) === '' || trim($val) === '-') {
            return null;
        }
        $clean = trim($val);
        $isNegative = (str_starts_with($clean, '(') && str_ends_with($clean, ')')) || str_starts_with($clean, '-');
        $clean = str_replace(['(', ')', '%', 'x', 'X', ' '], '', $clean);

        if (str_contains($clean, '.') && str_contains($clean, ',')) {
            $clean = str_replace('.', '', $clean);
            $clean = str_replace(',', '.', $clean);
        } elseif (str_contains($clean, ',') && !str_contains($clean, '.')) {
            $clean = str_replace(',', '.', $clean);
        } elseif (str_contains($clean, '.') && !str_contains($clean, ',')) {
            $parts = explode('.', $clean);
            if (count($parts) > 2) {
                $clean = str_replace('.', '', $clean);
            } elseif (count($parts) === 2 && strlen($parts[1]) === 3) {
                $clean = str_replace('.', '', $clean);
            }
        }

        $num = is_numeric($clean) ? (float) $clean : null;
        if ($num !== null && $isNegative && $num > 0) {
            $num = -$num;
        }
        return $num;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }
}
