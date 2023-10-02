<?php

namespace App\Services\Balance;

use App\Enums\ReasonType;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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

    public static function getONUSChartOverview(): array
    {
        return static::getChartOverview('ONUS');

    }

    public static function getONUSFarmingChartOverview(): array
    {
        return static::getChartOverview('ONUS Farming');
    }

    public static function getChartOverview($type): array
    {
        $time = now()->subMonth();
        $transactions = Transaction::query()->with('reason')->where('created_at', '>=', $time)->get();
        $init_cash = self::getBalance($time);

        $data = [];
        $dates = CarbonPeriod::create($transactions->first()->created_at, now());
        foreach ($dates as $date) {
            $money = $init_cash;
            foreach ($transactions as $transaction) {
                if (Carbon::make($transaction->created_at)->lt($date->endOfDay())) {
                    if ($type === 'ONUS') {
                        $money += match ($transaction->reason->type) {
                            ReasonType::CASH_TO_ONUS, ReasonType::DAILY_REVENUE_ONUS, ReasonType::FARM_REVENUE_ONUS, ReasonType::ONUS_FARMING_TO_ONUS => $transaction->price,
                            ReasonType::ONUS_TO_CASH, ReasonType::ONUS_TO_ONUS_FARMING => -$transaction->price,
                            default => 0,
                        };
                    } else {
                        $money += match ($transaction->reason->type) {
                            ReasonType::ONUS_TO_ONUS_FARMING => $transaction->price,
                            ReasonType::ONUS_FARMING_TO_ONUS => -$transaction->price,
                            default => 0,
                        };
                    }
                }
            }

            $data[$date->toDateString()] = $money;
        }

        return $data;
    }

}
