<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifyCoin extends Model
{

    protected $fillable = [
        'coin', 'coin_amount', 'balance', 'is_notify',
    ];

    public function getPrettyCoinAmountAttribute(): string
    {
        return rtrim(number_format($this->coin_amount, 16), 0);
    }

    public function getPrettyBalanceAttribute(): string
    {
        return number_format($this->balance);
    }

    public function getIsNotifyAttribute(): bool
    {
        if ($this->coin_amount !== null) {
            return true;
        }

        return $this->is_notify;
    }

}
