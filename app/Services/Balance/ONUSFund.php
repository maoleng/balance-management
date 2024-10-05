<?php

namespace App\Services\Balance;

use App\Enums\ReasonType;
use App\Models\Transaction;

class ONUSFund
{

    public static function getBalance($time = null): float
    {
        $types = ReasonType::asArray();

        return Transaction::query()
            ->selectRaw(
                "SUM(CASE
                    WHEN reasons.type IN ({$types['CASH_TO_ONUS']}, {$types['DAILY_REVENUE_ONUS']}, {$types['FARM_REVENUE_ONUS']}, {$types['ONUS_FARMING_TO_ONUS']}) THEN price
                    WHEN reasons.type IN ({$types['ONUS_TO_CASH']}, {$types['ONUS_TO_ONUS_FARMING']}) THEN -price
                END) AS onus_balance")
            ->join('reasons', 'transactions.reason_id', '=', 'reasons.id')
            ->where('created_at', '<', $time ?? now())
            ->first()->onus_balance ?? 0;
    }

    public static function getFarmingBalance()
    {
        $types = ReasonType::asArray();

        return Transaction::query()
            ->selectRaw(
                "SUM(CASE
                    WHEN reasons.type = {$types['ONUS_TO_ONUS_FARMING']} THEN price
                    WHEN reasons.type = {$types['ONUS_FARMING_TO_ONUS']} THEN -price
                END) AS onus_farming_balance")
            ->join('reasons', 'transactions.reason_id', '=', 'reasons.id')
            ->first()->onus_farming_balance ?? 0;
    }

}
