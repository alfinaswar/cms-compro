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

    // Generate URL dinamis
    public function getLinkAttribute()
    {
        $locale = app()->getLocale();

        if ($this->JenisLink === 'route' && $this->RouteName) {
            try {
                return \App\Services\LocalizedUrlService::route($this->RouteName, [], $locale);
            } catch (\Exception $e) {
                return '#';
            }
        }

        if (!empty($this->Url) && $this->Url !== '#') {
            $raw = trim($this->Url);
            if (str_starts_with($raw, '#') || preg_match('#^(mailto:|tel:)#i', $raw)) {
                return $raw;
            }
            if (preg_match('#^(https?:)?//#i', $raw)) {
                $host = strtolower((string) parse_url($raw, PHP_URL_HOST));
                $appHost = strtolower((string) parse_url(config('app.url'), PHP_URL_HOST));
                $reqHost = app()->bound('request') ? strtolower((string) request()->getHost()) : '';
                if ($host && $host !== $appHost && $host !== $reqHost) {
                    return $raw;
                }
                $raw = (string) (parse_url($raw, PHP_URL_PATH) ?? '');
            }

            $clean = trim($raw, '/');
            $segments = $clean === '' ? [] : explode('/', $clean);
            if (!empty($segments[0]) && in_array($segments[0], ['id', 'en'], true)) {
                array_shift($segments);
            }
            $sub = \App\Services\LocalizedUrlService::localizeSubPath(implode('/', $segments), $locale);
            return url($locale . ($sub !== '' ? '/' . $sub : ''));
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
