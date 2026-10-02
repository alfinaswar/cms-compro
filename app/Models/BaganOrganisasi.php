<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BaganOrganisasi extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'bagan_organisasis';
    protected $guarded = ['id'];

    protected $casts = [
        'TanggalDiperbarui' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }
}
