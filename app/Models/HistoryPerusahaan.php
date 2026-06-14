<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryPerusahaan extends Model
{
    use SoftDeletes;

    protected $table = 'history_perusahaans';

    protected $guarded = ['id'];
}
