<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsDetail extends Model
{
    protected $table = 'about_us_details';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
