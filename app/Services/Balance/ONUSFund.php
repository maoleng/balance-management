<?php

namespace App\Services\Balance;

use App\Enums\ReasonType;
use App\Models\Transaction;

class ONUSFund
{

    public static function getBalance(): float
    {
        $types = ReasonType::asArray();

        return Transaction::query()
            ->selectRaw(
                "SUM(CASE
                    WHEN reasons.type = {$types['CASH_TO_ONUS']} OR reasons.type = {$types['DAILY_REVENUE_ONUS']} OR reasons.type = {$types['FARM_REVENUE_ONUS']} THEN price * quantity
                    WHEN reasons.type = {$types['ONUS_TO_CASH']} THEN -price * quantity
                END) AS onus_balance")
            ->join('reasons', 'transactions.reason_id', '=', 'reasons.id')
            ->first()->onus_balance ?? 0;
    }

}
