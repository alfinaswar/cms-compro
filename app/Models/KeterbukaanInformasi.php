<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class KeterbukaanInformasi extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'keterbukaan_informasis';
    protected $guarded = ['id'];

    protected $casts = [
        'TanggalPublikasi' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }
}
