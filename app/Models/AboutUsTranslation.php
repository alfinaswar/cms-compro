<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsTranslation extends Model
{
    protected $table = 'AboutUsTranslations';
    protected $guarded = ['id'];

    public function about()
    {
        return $this->belongsTo(AboutUs::class, 'IdAbout');
    }
}
