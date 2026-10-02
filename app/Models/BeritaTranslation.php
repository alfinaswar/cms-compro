<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaTranslation extends Model
{
    protected $table = 'berita_translations';

    protected $guarded = ['id'];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'BeritaId');
    }
}
