<?php

namespace App\Http\Controllers;

use App\Enums\ReasonType;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;

class SiteController extends Controller
{

    public function index(): View
    {
        $spend = ReasonType::SPEND;
        $earn = ReasonType::EARN;
        $overview = Transaction::query()->selectRaw("
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

        $cash_balance = Transaction::query()
            ->selectRaw("
                SUM(CASE
                    WHEN reasons.type = $spend THEN -price * quantity
                    WHEN reasons.type = $earn THEN price * quantity
                END) AS cash_balance
            ")->join('reasons', 'transactions.reason_id', '=', 'reasons.id')->first()->cash_balance;
        $stock = (new BalanceController())->getStockBalance();
        $stock_balance = $stock['profit'] + $stock['invest'];
        $percent_stock_balance = $stock_balance * 100 / ($cash_balance + $stock['profit'] + $stock['invest']);

        return view('index', [
            'overview' => $overview,
            'cash_balance' => $cash_balance,
            'stock_balance' => $stock_balance,
            'stock_profit' => $stock['profit'],
            'percent_stock_balance' => $percent_stock_balance,
        ]);
    }

    public function market(): View
    {
        return view('market');
    }

}
