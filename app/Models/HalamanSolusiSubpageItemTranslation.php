<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HalamanSolusiSubpageItemTranslation extends Model
{
    protected $table = 'halaman_solusi_subpage_item_translations';

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
     * Relasi balik ke model item pemilik
     */
    public function item()
    {
        return $this->belongsTo(HalamanSolusiSubpageItem::class, 'HalamanSolusiSubpageItemId');
    }
}
