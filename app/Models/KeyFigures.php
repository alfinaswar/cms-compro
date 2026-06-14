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
}
