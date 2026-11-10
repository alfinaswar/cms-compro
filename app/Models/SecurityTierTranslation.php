<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityTierTranslation extends Model
{
    protected $table = 'security_tier_translations';
    protected $guarded = ['id'];

    protected $casts = [
        'Features' => 'array',
    ];

    public function securityTier()
    {
        return $this->belongsTo(SecurityTier::class, 'security_tier_id');
    }
}
