<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{

    protected $fillable = [
        'type', 'reason_id', 'created_at',
    ];

}
