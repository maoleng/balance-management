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
        $onus_balance = ONUSFund::getBalance();
        $onus_farming_balance = ONUSFund::getFarmingBalance();
        $crypto_balance = CryptoFund::getBalance();
        $balance = $cash_balance + $crypto_balance + $onus_balance + $onus_farming_balance;

        return view('index', [
            'overview' => $overview,
            'balance' => $balance,
            'cash_balance' => $cash_balance,
            'crypto_balance' => $crypto_balance,
            'onus_balance' => $onus_balance,
            'onus_farming_balance' => $onus_farming_balance,
            'cash_chart' => CashFund::getChartOverview(),
            'crypto_chart' => CryptoFund::getChartOverview(),
            'onus_chart' => ONUSFund::getONUSChartOverview(),
            'onus_farming_chart' => ONUSFund::getONUSFarmingChartOverview(),
        ]);

    }

    public function market(): View
    {
        return view('market');
    }

}
