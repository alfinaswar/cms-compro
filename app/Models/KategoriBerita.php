<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class KategoriBerita extends Model
{
    use SoftDeletes;

    protected $table = 'kategori_berita';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function getDisplayName(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return ($locale === 'en' && !empty($this->NamaKategoriEn))
            ? $this->NamaKategoriEn
            : (string) $this->NamaKategori;
    }

    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($kategori) {
    //         if (empty($kategori->Slug)) {
    //             $kategori->Slug = Str::slug($kategori->NamaKategori);
    //         }
    //     });
    //     static::updating(function ($kategori) {
    //         if ($kategori->isDirty('NamaKategori')) {
    //             $kategori->Slug = Str::slug($kategori->NamaKategori);
    //         }
    //     });
    // }
}
