<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticPage extends Model
{
    use SoftDeletes;

    protected $table = 'static_page';
    protected $guarded = ['id'];

    protected $casts = [
        'IsPublished' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(StaticPageTranslation::class, 'StaticPageId');
    }

    public function translate($locale = 'id')
    {
        return $this->translations->firstWhere('Locale', $locale) ?: new StaticPageTranslation();
    }
}
