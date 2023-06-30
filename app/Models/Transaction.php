<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'price', 'type', 'reason_id', 'created_at',
    ];

    public function getPrettyPriceAttribute(): string
    {
        return number_format($this->price);
    }

    public function getPrettyCreatedAtAttribute(): string
    {
        return Carbon::make($this->created_at)->format('d-m-y H:i:s');
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }

}
