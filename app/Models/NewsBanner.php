<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsBanner extends Model
{
    use SoftDeletes;

    protected $table = 'news_banners';

    protected $guarded = ['id'];

    protected $casts = [
        'IsActive' => 'boolean',
        'Urutan' => 'integer',
    ];
}
