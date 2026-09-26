<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPageTranslation extends Model
{
    protected $table = 'custom_page_translation';
    protected $guarded = ['id'];

    public function page()
    {
        return $this->belongsTo(CustomPages::class, 'CustomPageId');
    }
}
