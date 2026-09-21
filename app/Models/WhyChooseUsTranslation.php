<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseUsTranslation extends Model
{
    protected $table = 'why_choose_us_translations';
    protected $guarded = ['id'];

    public function whyChooseUs()
    {
        return $this->belongsTo(WhyChooseUs::class, 'why_choose_us_id');
    }
}
