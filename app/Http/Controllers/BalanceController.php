<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\NotifyCoin;
use App\Models\Reason;
use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BalanceController extends Controller
{

    public function getStockBalance(): array
    {
        $notify_coins = NotifyCoin::query()->get();
        $profit = 0;
        $invest = 0;
        foreach ($notify_coins as $notify_coin) {
            $invest += $notify_coin->balance;
            $profit += $notify_coin->coin_amount ?
                $notify_coin->coin_amount * $this->getRealMoneyOfCoin($notify_coin->coin) - $notify_coin->balance : 0;
        }

        return [
            'invest' => $invest,
            'profit' => $profit,
        ];
    }

    public function getRealMoneyOfCoin($coin): float
    {
        $response = (new Client)->post('https://p2p.binance.com/bapi/c2c/v2/friendly/c2c/adv/search', [
            'json' => [
                'asset' => $coin,
                'fiat' => 'VND',
                'merchantCheck' => true,
                'page' => 1,
                'payTypes' => ['BANK'],
                'publisherType' => null,
                'rows' => 1,
                'tradeType' => 'SELL'
            ],
        ])->getBody()->getContents();

        return (double) (json_decode($response, true)['data'])[0]['adv']['price'];
    }

}
