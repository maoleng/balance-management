<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reason extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name', 'label', 'is_group', 'is_child',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

}
