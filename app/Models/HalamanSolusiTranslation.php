<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HalamanSolusiTranslation extends Model
{
    protected $table = 'halaman_solusi_translations';

    protected $guarded = ['id'];

    protected $casts = [
        'FaqItems' => 'array',
    ];
    public function solusi()
    {
        return $this->belongsTo(HalamanSolusi::class, 'halaman_solusi_id');
    }
}
