<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HalamanSolusiDetailTranslation extends Model
{
    protected $table = 'halaman_solusi_detail_translations';

    protected $guarded = ['id'];

    /**
     * Relasi balik ke model detail
     */
    public function detail()
    {
        return $this->belongsTo(HalamanSolusidetail::class, 'halaman_solusi_detail_id');
    }
}
