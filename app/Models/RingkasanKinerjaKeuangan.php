<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RingkasanKinerjaKeuangan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'ringkasan_kinerja_keuangans';
    protected $guarded = ['id'];

    protected $casts = [
        'IsSubPos' => 'boolean',
        'IsBold' => 'boolean',
        'IsHighlight' => 'boolean',
        'Urutan' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }
}
