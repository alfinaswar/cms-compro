<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Menu';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'StatusAktif' => 'boolean',
        'TampilkanDiHeader' => 'boolean',
        'TampilkanDiFooter' => 'boolean',
        'Urutan' => 'integer',
    ];

    // Relasi parent
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'ParentId');
    }

    // Relasi children (sub menu)
    public function children()
    {
        return $this->hasMany(Menu::class, 'ParentId')->orderBy('Urutan', 'asc');
    }

    // Scope untuk menu header aktif
    public function scopeMenuHeader($query)
    {
        return $query->whereNull('ParentId')
            ->where('StatusAktif', true)
            ->where('TampilkanDiHeader', true)
            ->orderBy('Urutan', 'asc');
    }

    // Generate URL dinamis
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
}
