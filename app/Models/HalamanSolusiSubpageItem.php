<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HalamanSolusiSubpageItem extends Model
{
    use SoftDeletes;

    protected $table = 'halaman_solusi_subpage_items';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'Items' => 'array',
    ];

    /**
     * Relasi ke sub-halaman pemilik item ini
     */
    public function subpage()
    {
        return $this->belongsTo(HalamanSolusiSubpage::class, 'HalamanSolusiSubpageId');
    }
}
