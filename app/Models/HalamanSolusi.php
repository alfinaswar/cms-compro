<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HalamanSolusi extends Model
{
    use SoftDeletes;

    protected $table = 'halaman_solusis';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the details for the HalamanSolusi.
     */
    public function getSolusiDetail()
    {
        return $this->hasMany(HalamanSolusiDetail::class, 'HalamanSolusiId');
    }
}
