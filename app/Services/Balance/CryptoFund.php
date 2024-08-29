<?php

namespace App\Services\Balance;

use App\Enums\ReasonType;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;

class CryptoFund
{

    public static function getPortfolio(): array
    {
        $coins = self::getCoinsValue();
        $balance = 0;

        $portfolio = [];
        foreach ($coins as $coin_name => $coin) {

            if ($coin['quantity'] > 0) {
                $cur_coin_price = $coin['quantity'] * self::getRealMoneyOfCoin($coin_name);
                $profit = $cur_coin_price - $coin['price'];
                $portfolio[] = [
                    'name' => $coin_name,
                    'img' => getCoinLogo($coin_name),
                    'price' => $coin['price'],
                    'quantity' => $coin['quantity'],
                    'profit' => $profit,
                    'percent' => round(($profit / $coin['price'] * 100), 2).'%',
                    'color' => $profit > 0 ? 'primary' : 'danger',
                ];
                $balance += $cur_coin_price;
            }
        }

        return [
            'balance' => $balance,
            'coins' => $portfolio,
        ];
    }

    public static function getCoinsValue(): array
    {
        $transactions = Transaction::query()->whereHas('reason', function ($q) {
            $q->whereIn('type', [ReasonType::BUY_CRYPTO, ReasonType::SELL_CRYPTO]);
        })->with('reason')->get();

        $coins = [];
        foreach ($transactions as $transaction) {
            $coin_name = $transaction->coinName;
            $coins[$coin_name]['quantity'] = ($coins[$coin_name]['quantity'] ?? 0) +
                ($transaction->reason->type === ReasonType::BUY_CRYPTO ? $transaction->quantity : -$transaction->quantity);
            $coins[$coin_name]['price'] = ($coins[$coin_name]['price'] ?? 0) +
                ($transaction->reason->type === ReasonType::BUY_CRYPTO ? $transaction->price : -$transaction->price);
        }

        return $coins;
    }

    public static function getRealMoneyOfCoin($coin): float
    {
        if (in_array($coin, ['USDT', 'BTC', 'BNB', 'ETH', 'C98', 'XRP', 'ADA', 'SLP', 'DOGE', 'TUSD'])) {
            return self::getP2PCoinPrice($coin);
        }
        $response = (new Client)->get("https://api.binance.com/api/v3/ticker/price?symbol={$coin}USDT")->getBody()->getContents();
        $coin_in_usdt_price = (double) json_decode($response, true)['price'];

        return self::getP2PCoinPrice('USDT') * $coin_in_usdt_price;
    }

    private static function getP2PCoinPrice($coin): float
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
