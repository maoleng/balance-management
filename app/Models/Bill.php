<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name', 'price', 'image', 'pay_at',
    ];

    protected $casts = [
        'pay_at' => 'datetime'
    ];

    public function getPayHourLeftAttribute()
    {
        $diff = $this->pay_at->diffInHours(now());

        return $this->pay_at->lt(now()) ? -$diff : $diff;
    }

    public function getPayDateLeftTagAttribute(): string
    {
        $left = $this->pay_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, parts: 2);
        $hour_left = $this->payHourLeft;

        if ($hour_left > 7 * 24) {
            $color = 'success';
        } elseif ($hour_left > 3 * 24) {
            $color = 'warning';
        } elseif ($hour_left < 3 * 24 && $hour_left > 0) {
            $color = 'danger';
        }

        return isset($color) ?
            <<<HTML
                <div class="chip chip-outline chip-$color ms-05">&nbsp;&nbsp;$left&nbsp;&nbsp;</div>
            HTML
            : '';
    }

}
