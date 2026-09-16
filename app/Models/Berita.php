<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Berita extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'beritas';

    protected $guarded = ['id'];

    protected $casts = [
        'TanggalPublikasi' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['Kategori', 'Tags', 'Status', 'TanggalPublikasi'])
            ->logOnlyDirty();
        // Catatan: Judul/Konten di-log di controller agar bisa ambil dari translation
    }

    // Relasi ke tabel terjemahan
    public function translations()
    {
        return $this->hasMany(BeritaTranslation::class, 'BeritaId');
    }
    public function translate($locale = 'id')
    {
        return $this->translations->firstWhere('Locale', $locale) ?: new BeritaTranslation();
    }
}
