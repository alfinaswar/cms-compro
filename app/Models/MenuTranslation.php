<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuTranslation extends Model
{
    protected $table = 'menu_translations';

    protected $fillable = [
        'MenuId',
        'Locale',
        'NamaMenu'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'MenuId');
    }
}
