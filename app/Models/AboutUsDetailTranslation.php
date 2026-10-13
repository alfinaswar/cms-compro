<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsDetailTranslation extends Model
{
    protected $table = 'AboutUsDetailTranslations';
    protected $guarded = ['id'];

    public function detail()
    {
        return $this->belongsTo(AboutUsDetail::class, 'IdAboutUsDetail');
    }
}
