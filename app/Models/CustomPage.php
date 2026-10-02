<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomPage extends Model
{
    use SoftDeletes;

    protected $table = 'custom_pages';
    protected $guarded = ['id'];

    protected $casts = [
        'IsPublished' => 'boolean',
        'ParentId' => 'integer',
        'Urutan' => 'integer',
    ];

    // Relasi ke Parent
    public function parent()
    {
        return $this->belongsTo(CustomPage::class, 'ParentId');
    }

    // Relasi ke Children (Sub-pages)
    public function children()
    {
        return $this->hasMany(CustomPage::class, 'ParentId')->orderBy('Urutan');
    }

    // Relasi ke Translations
    public function translations()
    {
        return $this->hasMany(CustomPageTranslation::class, 'CustomPageId');
    }

    // Helper untuk get translation
    public function translate($locale = 'id')
    {
        return $this->translations->firstWhere('Locale', $locale) ?: new CustomPageTranslation();
    }

    // Scope untuk hanya root pages
    public function scopeRoot($query)
    {
        return $query->whereNull('ParentId');
    }

    // Get all children recursively
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    // Get level depth
    public function getLevelAttribute()
    {
        $level = 0;
        $current = $this;
        while ($current->ParentId) {
            $level++;
            $current = $this->parent;
        }
        return $level;
    }
}
