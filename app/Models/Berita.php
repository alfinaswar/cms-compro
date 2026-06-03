<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Berita extends Model
{
    use SoftDeletes;

    protected $table = 'beritas';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'TanggalPublikasi' => 'datetime',
    ];

    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($berita) {
    //         if (empty($berita->Slug)) {
    //             $berita->Slug = Str::slug($berita->Judul) . '-' . time();
    //         }
    //     });
    //     static::updating(function ($berita) {
    //         if ($berita->isDirty('Judul')) {
    //             $berita->Slug = Str::slug($berita->Judul) . '-' . time();
    //         }
    //     });
    // }
}
