<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientLogo extends Model
{
    use SoftDeletes;

    protected $table = 'client_logos';

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
        return $this->hasMany(ClientLogoDetail::class, 'IdClientLogo', 'id');
    }
}
