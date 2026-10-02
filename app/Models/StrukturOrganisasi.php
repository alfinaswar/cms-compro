<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StrukturOrganisasi extends Model
{
    use SoftDeletes;

    protected $table = 'struktur_organisasis';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'Urutan' => 'integer',
    ];
    public function details()
    {
        return $this->hasMany(StrukturOrganisasiDetail::class, 'StrukturOrganisasiId')
            ->where('Status', 'Aktif')
            ->orderBy('Urutan');
    }
    public function allDetails()
    {
        return $this->hasMany(StrukturOrganisasiDetail::class, 'StrukturOrganisasiId')
            ->orderBy('Urutan');
    }
}
