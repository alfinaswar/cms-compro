<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationEmailRecipient extends Model
{
    use SoftDeletes;

    protected $table = 'notification_email_recipient';

    protected $guarded = ['id'];

    protected $casts = [
        'StatusAktif' => 'boolean',
    ];
}
