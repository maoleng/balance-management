<?php

namespace App\Models;

use App\Enums\ReasonType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'price', 'quantity', 'reason_id', 'transaction_id', 'external', 'created_at',
    ];

    protected $casts = [
        'external' => 'json',
        'created_at' => 'date',
    ];

    public function getPrettyCreatedAtAttribute(): string
    {
        return Carbon::make($this->created_at)->format('d-m-y H:i:s');
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
        $coin = strtolower($this->coinName);

        return "https://assets.coincap.io/assets/icons/$coin@2x.png";
    }

    public function appendCashData(): void
    {
        $this->append('isCredit');
        if ($this->reason->type === ReasonType::GROUP) {
            $this->append('totalPrice');
        }
        $this->reason->append('shortName');
    }

}
