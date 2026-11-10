<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyFigures extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'key_figures';

    protected $guarded = ['id'];

    public function getKonten($locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        return ($locale === 'en' && !empty($this->KontenEn)) ? (string)$this->KontenEn : (string)($this->Konten ?? '');
    }

    public function getKeterangan($locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        return ($locale === 'en' && !empty($this->KeteranganEn)) ? (string)$this->KeteranganEn : (string)($this->Keterangan ?? '');
    }
}
