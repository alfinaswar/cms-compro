<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class LowonganKerja extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lowongan_kerjas';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    // Scope untuk lowongan yang masih buka
    public function scopeActive($query)
    {
        return $query->where('Status', 'Buka');
    }
    public function getSlugAttribute()
    {
        return Str::slug($this->Posisi) . '-' . $this->id;
    }
    public function getBatasWaktuFormattedAttribute()
    {
        return Carbon::parse($this->BatasWaktu)->format('jS F, Y');
    }
    public function getMasihBerlakuAttribute()
    {
        return Carbon::parse($this->BatasWaktu)->isFuture();
    }
    public function getLamaran()
    {
        return $this->hasMany(LamaranKerja::class, 'LowonganKerjaId', 'id');
    }
}
