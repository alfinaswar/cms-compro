<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HalamanSolusiSubpageTranslation extends Model
{
    protected $table = 'halaman_solusi_subpage_translations';

    protected $guarded = ['id'];

    /**
     * Relasi balik ke model sub-halaman pemilik
     */
    public function subpage()
    {
        return $this->belongsTo(HalamanSolusiSubpage::class, 'HalamanSolusiSubpageId');
    }
}
