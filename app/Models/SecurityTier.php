<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityTier extends Model
{
    protected $table = 'security_tiers';
    protected $guarded = ['id'];

    public function translations()
    {
        return $this->hasMany(SecurityTierTranslation::class, 'security_tier_id');
    }

    public function translate($locale = 'id')
    {
        return $this->translations->firstWhere('Locale', $locale) ?: new SecurityTierTranslation();
    }
}
