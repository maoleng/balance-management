<?php

namespace App\Models;

use App\Enums\ReasonType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'price', 'quantity', 'reason_id', 'transaction_id', 'external', 'created_at',
    ];

    protected $casts = [
        'external' => 'json',
        'created_at' => 'datetime',
    ];

    public function getPrettyCreatedAtAttribute(): string
    {
        if ($this->created_at->isToday()) {
            return 'Hôm nay';
        }
        if ($this->created_at->isYesterday()) {
            return 'Hôm qua';
        }

        return Str::ucfirst($this->created_at->isoFormat('dddd')).', '.$this->created_at->format('d-m-Y');
    }

    public function getPrettyCreatedTimeAttribute(): string
    {
        return $this->created_at->format('H:i');
    }

    public function getPrettyCreatedAtWithTimeAttribute(): string
    {
        return $this->prettyCreatedAt.' - '.$this->prettyCreatedTime;
    }

    public function reason(): BelongsTo
    {
        return $this->belongsTo(Reason::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(__CLASS__);
    }

    public function getIsCreditAttribute(): bool
    {
        return isset($this->external['is_credit']);
    }

    public function getIsVIBAttribute(): bool
    {
        return isset($this->external['is_vib']);
    }

    public function getCoinNameAttribute(): ?string
    {
        return $this->external['coin'] ?? null;
    }

    public function getTotalPriceAttribute()
    {
        return $this->transactions->sum(fn($transaction) => $transaction->price * $transaction->quantity);
    }

    public function getCoinLogoAttribute(): string
    {
        return getCoinLogo($this->coinName);
    }

    public function appendCashData(): Transaction
    {
        $this->append('isCredit', 'isVIB', 'prettyCreatedTime');
        if ($this->reason->type === ReasonType::GROUP) {
            $this->append('totalPrice');
        }

        return $this;
    }

    public function appendONUSData(): Transaction
    {
        $this->append('coinName', 'prettyCreatedTime');

        return $this;
    }

    public function appendCryptoData(): Transaction
    {
        $this->append('coinLogo', 'coinName', 'prettyCreatedTime');

        return $this;
    }

}
