<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class PenghargaanPerusahaan extends Model
{
    protected $table = 'penghargaan_perusahaans';
    protected $guarded = ['id'];

    /**
     * Relationship: PenghargaanPerusahaan has many details.
     */
    public function details(): HasMany
    {
        return $this->hasMany(PenghargaanPerusahaanDetail::class, 'PenghargaanId');
    }
}
