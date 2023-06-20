<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinPrice extends Model
{

    protected $fillable = [
        'coin', 'price', 'profit', 'created_at',
    ];

}
