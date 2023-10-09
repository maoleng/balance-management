<?php

namespace App\Services\Balance;

use App\Enums\ReasonType;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CashFund
{

    public static function getOverview(): Model
    {
        $spend = ReasonType::SPEND;
        $earn = ReasonType::EARN;

        return Transaction::query()->selectRaw("
            SUM(CASE WHEN reasons.type = $spend THEN price * quantity ELSE 0 END) AS total_spend,
            SUM(CASE WHEN reasons.type = $earn THEN price * quantity ELSE 0 END) AS total_earn,
            SUM(CASE WHEN reasons.type = $spend AND DATE(created_at) = CURDATE() THEN price * quantity ELSE 0 END) AS spend_today,
            SUM(CASE WHEN reasons.type = $earn AND DATE(created_at) = CURDATE() THEN price * quantity ELSE 0 END) AS earn_today,
            SUM(CASE WHEN reasons.type = $spend AND YEARWEEK(DATE_ADD(created_at, INTERVAL 1 DAY)) = YEARWEEK(CURDATE()) THEN price * quantity ELSE 0 END) AS spend_week,
            SUM(CASE WHEN reasons.type = $earn AND YEARWEEK(DATE_ADD(created_at, INTERVAL 1 DAY)) = YEARWEEK(CURDATE()) THEN price * quantity ELSE 0 END) AS earn_week,
            SUM(CASE WHEN reasons.type = $spend AND MONTH(created_at) = MONTH(CURDATE()) THEN price * quantity ELSE 0 END) AS spend_month,
            SUM(CASE WHEN reasons.type = $earn AND MONTH(created_at) = MONTH(CURDATE()) THEN price * quantity ELSE 0 END) AS earn_month,
            SUM(CASE WHEN reasons.type = $spend AND YEAR(created_at) = YEAR(CURDATE()) THEN price * quantity ELSE 0 END) AS spend_year,
            SUM(CASE WHEN reasons.type = $earn AND YEAR(created_at) = YEAR(CURDATE()) THEN price * quantity ELSE 0 END) AS earn_year,
            SUM(CASE WHEN reasons.type = $spend THEN price * quantity ELSE 0 END) AS total_spend,
            SUM(CASE WHEN reasons.type = $earn THEN price * quantity ELSE 0 END) AS total_earn
        ")->join('reasons', 'transactions.reason_id', '=', 'reasons.id')->first();
    }

    public static function getBalance($until = null): float
    {
        $types = ReasonType::asArray();

        return env('AUTH_INIT_CASH') + Transaction::query()
            ->where('external->is_credit', null)
            ->selectRaw(
                "SUM(CASE
                    WHEN reasons.type = {$types['SPEND']} THEN -price * quantity
                    WHEN reasons.type = {$types['CASH_TO_ONUS']} OR reasons.type = {$types['BUY_CRYPTO']} THEN -price
                    WHEN reasons.type = {$types['EARN']} OR reasons.type = {$types['ONUS_TO_CASH']} OR reasons.type = {$types['SELL_CRYPTO']} THEN price
                END) AS cash_balance")
            ->join('reasons', 'transactions.reason_id', '=', 'reasons.id')
            ->where('created_at', '<', $until ?? now())
            ->first()->cash_balance ?? 0;
    }

    public static function getChartOverview(): array
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
                    $money += match ($transaction->reason->type) {
                        ReasonType::EARN, ReasonType::ONUS_TO_CASH, ReasonType::SELL_CRYPTO => $transaction->price,
                        ReasonType::CASH_TO_ONUS, ReasonType::BUY_CRYPTO => -$transaction->price,
                        ReasonType::SPEND => -$transaction->price * $transaction->quantity,
                        default => 0,
                    };
                }
            }

            $data[$date->toDateString()] = round($money);
        }

        return $data;
    }

    public static function getOutstandingCredit($until = null): float
    {
        $spend = ReasonType::SPEND;

        return Transaction::query()
            ->where('external->is_credit', true)
            ->where('created_at', '<', $until ?? now())
            ->selectRaw(
                "SUM(CASE
                    WHEN reasons.type = $spend THEN -price * quantity
                END) AS cash_balance")
            ->join('reasons', 'transactions.reason_id', '=', 'reasons.id')
            ->where('created_at', '<', $until ?? now())
            ->first()->cash_balance ?? 0;
    }

}
