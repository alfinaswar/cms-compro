<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menu';

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = ['id'];

    protected $casts = [
        'StatusAktif' => 'boolean',
        'TampilkanDiHeader' => 'boolean',
        'TampilkanDiFooter' => 'boolean',
        'Urutan' => 'integer',
    ];

    // ==========================================
    // RELASI TREE (Existing)
    // ==========================================

    // Relasi parent
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'ParentId');
    }

    // Relasi children (sub menu)
    public function children()
    {
        return $this->hasMany(Menu::class, 'ParentId')
            ->with('translations') // ✅ Auto-load translations untuk submenu
            ->orderBy('Urutan', 'asc');
    }

    // Scope untuk menu header aktif
    public function scopeMenuHeader($query)
    {
        return $query->whereNull('ParentId')
            ->where('StatusAktif', true)
            ->where('TampilkanDiHeader', true)
            ->with('translations', 'children.translations') // ✅ Eager load translations
            ->orderBy('Urutan', 'asc');
    }

    // Generate URL dinamis (Existing)
    public function getLinkAttribute()
    {
        if ($this->JenisLink === 'route' && $this->RouteName) {
            try {
                return route($this->RouteName);
            } catch (\Exception $e) {
                return '#';
            }
        }

        if ($this->JenisLink === 'page' && $this->Url) {
            return url($this->Url);
        }

        return $this->Url ?? '#';
    }

    // ==========================================
    // MULTI-LANGUAGE SUPPORT (BARU)
    // ==========================================

    /**
     * Relasi ke tabel terjemahan menu
     */
    public function translations()
    {
        return $this->hasMany(MenuTranslation::class, 'MenuId');
    }

    /**
     * Helper untuk mengambil terjemahan berdasarkan bahasa
     *
     * @param string $locale
     * @return MenuTranslation
     */
    public function translate($locale = 'id')
    {
        // firstWhere akan return null jika tidak ada, fallback ke instance kosong
        return $this->translations->firstWhere('Locale', $locale) ?: new MenuTranslation();
    }

    /**
     * Accessor: nama menu sesuai bahasa aktif dengan fallback ke NamaMenu default
     * Gunakan di frontend: {{ $menu->display_name }}
     */
    public function getDisplayNameAttribute()
    {
        $locale = app()->getLocale();
        $trans = $this->translate($locale);

        // Fallback: jika terjemahan kosong, pakai NamaMenu dari tabel utama
        return $trans->NamaMenu ?: $this->NamaMenu;
    }
}
