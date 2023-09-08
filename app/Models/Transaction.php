<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'price', 'type', 'reason_id', 'created_at',
    ];

    public function getPrettyCreatedAtAttribute(): string
    {
        return Carbon::make($this->created_at)->format('d-m-y H:i:s');
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }

}
