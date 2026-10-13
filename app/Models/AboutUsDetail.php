<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsDetail extends Model
{
    protected $table = 'about_us_details';
    protected $guarded = ['id'];

    public function about()
    {
        return $this->belongsTo(AboutUs::class, 'IdAbout');
    }

    public function translations()
    {
        return $this->hasMany(AboutUsDetailTranslation::class, 'IdAboutUsDetail');
    }

    public function translate($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $trans = $this->translations->firstWhere('Locale', $locale);

        if (!$trans && $locale !== 'id') {
            $trans = $this->translations->firstWhere('Locale', 'id');
        }

        if (!$trans) {
            $fallback = new AboutUsDetailTranslation();
            $fallback->Locale = $locale;
            $fallback->Judul = $this->Judul;
            $fallback->Deskripsi = $this->Deskripsi;
            return $fallback;
        }

        return $trans;
    }
}
