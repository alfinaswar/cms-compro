<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InformasiSaham extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'informasi_sahams';
    protected $guarded = ['id'];

    protected $casts = [
        'ChartData' => 'array',
        'HargaTerakhir' => 'decimal:2',
        'Perubahan' => 'decimal:2',
        'PersentasePerubahan' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }
}
