<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HalamanSolusiSubpage extends Model
{
    use SoftDeletes;

    protected $table = 'halaman_solusi_subpages';

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
        'IsPublished' => 'boolean',
    ];

    /**
     * Relasi ke detail solusi (pemilik sub-halaman ini)
     */
    public function detail()
    {
        return $this->belongsTo(HalamanSolusiDetail::class, 'HalamanSolusiDetailId', 'id');
    }

    /**
     * Relasi ke halaman solusi induk
     */
    public function solusi()
    {
        return $this->hasOneThrough(
            HalamanSolusi::class,
            HalamanSolusiDetail::class,
            'id',
            'id',
            'HalamanSolusiDetailId',
            'HalamanSolusiId'
        );
    }

    /**
     * Relasi ke item repeater sub-halaman
     */
    public function items()
    {
        return $this->hasMany(HalamanSolusiSubpageItem::class, 'HalamanSolusiSubpageId')->orderBy('SortOrder');
    }

    /**
     * Ambil item berdasarkan section (section1 | section2 | section3 | faq)
     */
    public function itemsBySection($section)
    {
        return $this->items->where('Section', $section)->values();
    }

    protected static function booted(): void
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('halaman_solusi');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('halaman_solusi');
        });
    }
}
