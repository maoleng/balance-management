<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reason extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name', 'type', 'label', 'image', 'category_id',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getCoinLogoAttribute(): string
    {
        [, $coin] = explode(' ', strtolower($this->name));

        return "https://assets.coincap.io/assets/icons/$coin@2x.png";
    }

    public function getCoinNameAttribute(): string
    {
        [, $coin] = explode(' ', $this->name);

        return $coin;
    }

}
