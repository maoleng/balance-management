<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Model
{

    use Notifiable;
    use HasPushSubscriptions;

    protected $fillable = [
        'name', 'email', 'avatar', 'created_at',
    ];

}
