<?php

namespace App\Http\Controllers;

use App\Services\Balance\CashFund;
use App\Services\Balance\CryptoFund;
use App\Services\Balance\ONUSFund;
use Illuminate\Contracts\View\View;

class SiteController extends Controller
{

    public function index(): View
    {
        $overview = CashFund::getOverview();
        $cash_balance = CashFund::getBalance();
        $outstanding_credit = CashFund::getOutstandingCredit();
        $onus_balance = ONUSFund::getBalance();
        $onus_farming_balance = ONUSFund::getFarmingBalance();
        $onus_future_balance = ONUSFund::getFutureBalance();
        $crypto_balance = CryptoFund::getBalance();
        $balance = $cash_balance + $crypto_balance + $onus_balance + $onus_farming_balance + $onus_future_balance;

        return view('index', [
            'overview' => $overview,
            'balance' => $balance,
            'cash_balance' => $cash_balance,
            'outstanding_credit' => $outstanding_credit,
            'crypto_balance' => $crypto_balance,
            'onus_balance' => $onus_balance,
            'onus_farming_balance' => $onus_farming_balance,
            'onus_future_balance' => $onus_future_balance,
            'cash_chart' => CashFund::getChartOverview(),
            'crypto_chart' => CryptoFund::getChartOverview(),
            'onus_chart' => ONUSFund::getONUSChartOverview(),
            'onus_farming_chart' => ONUSFund::getONUSFarmingChartOverview(),
            'onus_future_chart' => ONUSFund::getONUSFutureChartOverview(),
        ]);

    }

    public function market(): View
    {
        return view('market');
    }

}
