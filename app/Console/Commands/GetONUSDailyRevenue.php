<?php

namespace App\Console\Commands;

use App\Enums\ReasonType;
use App\Models\Reason;
use App\Models\Transaction;
use App\Services\Balance\ONUSFund;
use Illuminate\Console\Command;

class GetONUSDailyRevenue extends Command
{

    protected $signature = 'onus:daily_revenue';

    public function handle(): void
    {
        $balance = ONUSFund::getBalance();
        $revenue = round($balance * 0.033 / 100);

        $type = ReasonType::DAILY_REVENUE_ONUS;
        $reason_id = Reason::query()->firstOrCreate(
            [
                'type' => $type,
            ],
            [
                'name' => ReasonType::getDescription($type),
                'type' => $type,
            ]
        )->id;

        Transaction::query()->create([
            'price' => $revenue,
            'reason_id' => $reason_id,
            'created_at' => now(),
        ]);
    }
}
