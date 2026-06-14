<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HalamanSolusiDetail extends Model
{
    use SoftDeletes;

    protected $table = 'halaman_solusi_details';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the parent HalamanSolusi.
     */
    public function getSolusi()
    {
        return $this->belongsTo(HalamanSolusi::class, 'HalamanSolusiId');
    }
}
