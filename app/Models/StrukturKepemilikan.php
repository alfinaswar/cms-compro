<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StrukturKepemilikan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'struktur_kepemilikans';
    protected $guarded = ['id'];

    protected $casts = [
        'JumlahSaham' => 'integer',
        'Persentase' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

}
