<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StrukturOrganisasiDetail extends Model
{
    use SoftDeletes;

    protected $table = 'struktur_organisasi_details';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'Urutan' => 'integer',
    ];

    // Relasi: Detail milik satu Header
    public function section()
    {
        return $this->belongsTo(StrukturOrganisasi::class, 'StrukturOrganisasiId');
    }
}
