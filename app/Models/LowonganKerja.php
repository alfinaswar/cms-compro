<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LowonganKerja extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'lowongan_kerjas';

    protected $fillable = [
        'Posisi',
        'Kota',
        'Deskripsi',
        'Kualifikasi',
        'BatasWaktu',
        'Status',
        'UserCreate',
        'UserUpdate',
        'UserDelete',
    ];

    protected $casts = [
        'BatasWaktu' => 'date',
    ];

    // Scope untuk lowongan yang masih buka
    public function scopeActive($query)
    {
        return $query->where('Status', 'Buka');
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->translate('id')->Posisi ?? 'lowongan') . '-' . $this->id;
    }

    public function getBatasWaktuFormattedAttribute()
    {
        return $this->BatasWaktu ? Carbon::parse($this->BatasWaktu)->format('jS F, Y') : 'Secepatnya';
    }

    public function getMasihBerlakuAttribute()
    {
        return $this->BatasWaktu ? Carbon::parse($this->BatasWaktu)->isFuture() : true;
    }
    public function getLamaran()
    {
        return $this->hasMany(LamaranKerja::class, 'LowonganKerjaId', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['Kota', 'BatasWaktu', 'Status'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Lowongan kerja telah {$eventName}");
    }

    // Relasi ke tabel terjemahan
    public function translations()
    {
        return $this->hasMany(LowonganKerjaTranslation::class, 'LowonganKerjaId');
    }
    public function translate($locale = 'id')
    {
        return $this->translations->firstWhere('Locale', $locale) ?: new LowonganKerjaTranslation();
    }
}
