<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us';
    protected $guarded = ['id'];

    public function getDetail()
    {
        return $this->hasMany(AboutUsDetail::class, 'IdAbout');
    }

    public function translations()
    {
        return $this->hasMany(AboutUsTranslation::class, 'IdAbout');
    }

    public function translate($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $trans = $this->translations->firstWhere('Locale', $locale);

        // Fallback ke Indonesia jika locale tidak ada
        if (!$trans && $locale !== 'id') {
            $trans = $this->translations->firstWhere('Locale', 'id');
        }

        // Fallback ke kolom lama (backward compat)
        if (!$trans) {
            $fallback = new AboutUsTranslation();
            $fallback->Locale = $locale;
            $fallback->SubJudul = $this->SubJudul;
            $fallback->Judul = $this->Judul;
            $fallback->Deskripsi = $this->Deskripsi;
            return $fallback;
        }

        return $trans;
    }
}
