<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinPrice extends Model
{

    protected $fillable = [
        'coin', 'price', 'real_money', 'profit', 'created_at',
    ];

}
