<?php

namespace App\Services\Balance;

use Illuminate\Support\Facades\File;
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
        return Transaction::query()->select(
            DB::raw('SUM(CASE WHEN reasons.type = 1 AND DATE(transactions.created_at) = CURDATE() THEN transactions.price ELSE 0 END) AS earn_today'),
            DB::raw('SUM(CASE WHEN reasons.type = 1 AND YEARWEEK(transactions.created_at, 1) = YEARWEEK(NOW(), 1) THEN transactions.price ELSE 0 END) AS earn_week'),
            DB::raw('SUM(CASE WHEN reasons.type = 1 AND MONTH(transactions.created_at) = MONTH(CURDATE()) THEN transactions.price ELSE 0 END) AS earn_month'),
            DB::raw('SUM(CASE WHEN reasons.type = 1 AND YEAR(transactions.created_at) = YEAR(CURDATE()) THEN transactions.price ELSE 0 END) AS earn_year'),
            DB::raw('SUM(CASE WHEN reasons.type = 0 AND DATE(transactions.created_at) = CURDATE() THEN transactions.price ELSE 0 END) AS spend_today'),
            DB::raw('SUM(CASE WHEN reasons.type = 0 AND YEARWEEK(transactions.created_at, 1) = YEARWEEK(NOW(), 1) THEN transactions.price ELSE 0 END) AS spend_week'),
            DB::raw('SUM(CASE WHEN reasons.type = 0 AND MONTH(transactions.created_at) = MONTH(CURDATE()) THEN transactions.price ELSE 0 END) AS spend_month'),
            DB::raw('SUM(CASE WHEN reasons.type = 0 AND YEAR(transactions.created_at) = YEAR(CURDATE()) THEN transactions.price ELSE 0 END) AS spend_year'),
            DB::raw('SUM(CASE WHEN reasons.type = 1 AND MONTH(transactions.created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH) THEN transactions.price ELSE 0 END) AS last_month_earn'),
            DB::raw('SUM(CASE WHEN reasons.type = 0 AND MONTH(transactions.created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH) THEN transactions.price ELSE 0 END) AS last_month_spend')
        )->join('reasons', 'transactions.reason_id', '=', 'reasons.id')->first();
    }

    public static function getBalance($until = null): int
    {
        $types = ReasonType::asArray();

        return (int) File::get('init.txt') + Transaction::query()
            ->where('external->is_credit', null)
            ->where('external->is_vib', null)
            ->where('external->is_lio', null)
            ->selectRaw(
                "SUM(CASE
                    WHEN reasons.type = {$types['SPEND']} THEN -price * quantity
                    WHEN reasons.type IN ({$types['CASH_TO_ONUS']}, {$types['CREDIT_SETTLEMENT']}, {$types['VIB_SETTLEMENT']}, {$types['LIO_SETTLEMENT']}, {$types['BUY_CRYPTO']}) THEN -price
                    WHEN reasons.type IN ({$types['EARN']}, {$types['ONUS_TO_CASH']}, {$types['SELL_CRYPTO']}) THEN price
                END) AS cash_balance")
            ->join('reasons', 'transactions.reason_id', '=', 'reasons.id')
            ->where('created_at', '<', $until ?? now())
            ->first()->cash_balance ?? 0;
    }

    public static function getOutstandingCredit($until = null): float
    {
        $types = ReasonType::asArray();

        return Transaction::query()
            ->where(function ($q) {
                $q->where('external->is_credit', true)->orWhereHas('reason', function ($q) {
                    $q->where('type', ReasonType::CREDIT_SETTLEMENT);
                });
            })
            ->where('created_at', '<', $until ?? now())
            ->selectRaw(
                "SUM(CASE
                    WHEN reasons.type = {$types['SPEND']} THEN -price * quantity
                    WHEN reasons.type = {$types['CREDIT_SETTLEMENT']} THEN price
                END) AS cash_balance")
            ->join('reasons', 'transactions.reason_id', '=', 'reasons.id')
            ->first()->cash_balance ?? 0;
    }

    public static function getOutstandingVIB($until = null): float
    {
        $types = ReasonType::asArray();

        return Transaction::query()
            ->where(function ($q) {
                $q->where('external->is_vib', true)->orWhereHas('reason', function ($q) {
                    $q->where('type', ReasonType::VIB_SETTLEMENT);
                });
            })
            ->where('created_at', '<', $until ?? now())
            ->selectRaw(
                "SUM(CASE
                    WHEN reasons.type = {$types['SPEND']} THEN -price * quantity
                    WHEN reasons.type = {$types['VIB_SETTLEMENT']} THEN price
                END) AS cash_balance")
            ->join('reasons', 'transactions.reason_id', '=', 'reasons.id')
            ->first()->cash_balance ?? 0;
    }

    public static function getOutstandingLIO($until = null): float
    {
        $types = ReasonType::asArray();

        return Transaction::query()
            ->where(function ($q) {
                $q->where('external->is_lio', true)->orWhereHas('reason', function ($q) {
                    $q->where('type', ReasonType::LIO_SETTLEMENT);
                });
            })
            ->where('created_at', '<', $until ?? now())
            ->selectRaw(
                "SUM(CASE
                    WHEN reasons.type = {$types['SPEND']} THEN -price * quantity
                    WHEN reasons.type = {$types['LIO_SETTLEMENT']} THEN price
                END) AS cash_balance")
            ->join('reasons', 'transactions.reason_id', '=', 'reasons.id')
            ->first()->cash_balance ?? 0;
    }

}
