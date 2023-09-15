<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reason extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name', 'type', 'label', 'is_group',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

}
