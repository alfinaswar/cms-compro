<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseUs extends Model
{
    protected $table = 'why_choose_us';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    // Relasi ke tabel terjemahan
    public function translations()
    {
        return $this->hasMany(WhyChooseUsTranslation::class, 'why_choose_us_id');
    }

    // Helper untuk mengambil terjemahan
    public function translate($locale = 'id')
    {
        return $this->translations->firstWhere('Locale', $locale) ?: new WhyChooseUsTranslation();
    }
}
