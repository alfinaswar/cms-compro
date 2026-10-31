<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterProduk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_produks';

    protected $fillable = [
        'parent_id',
        'Nama',
        'NamaTranslate',
        'Urutan',
        'StatusAktif',
        'UserCreate',
        'UserUpdate',
        'UserDelete',
    ];

    protected $casts = [
        'StatusAktif' => 'boolean',
        'Urutan' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(MasterProduk::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MasterProduk::class, 'parent_id')->orderBy('Urutan', 'asc')->orderBy('id', 'asc');
    }

    public function activeChildren()
    {
        return $this->hasMany(MasterProduk::class, 'parent_id')
            ->where('StatusAktif', true)
            ->orderBy('Urutan', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * Dapatkan nama sesuai bahasa aktif
     */
    public function getTranslatedNamaAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && !empty($this->NamaTranslate)) {
            return $this->NamaTranslate;
        }
        return $this->Nama ?? '';
    }
}
