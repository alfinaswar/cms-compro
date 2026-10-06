<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPageTranslation extends Model
{
    protected $table = 'static_page_translation';
    protected $guarded = ['id'];

    public function page()
    {
        return $this->belongsTo(StaticPage::class, 'StaticPageId');
    }
}
