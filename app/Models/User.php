<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{

    use Notifiable;
    use HasPushSubscriptions;

    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'avatar', 'created_at',
    ];

}
