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

    public static function getBalance(): float
    {
        $coins = self::getCoinsValue();
        $balance = 0;
        foreach ($coins as $coin_name => $coin) {
            if ($coin['quantity'] > 0) {
                $balance += $coin['quantity'] * self::getRealMoneyOfCoin($coin_name);
            }
        }

        return $balance;
    }

    public static function getChartOverview(): array
    {
        $data = File::json('crypto-history.json');

        return array_slice($data, -30);
    }

    public static function getCoinsValue(): array
    {
        $transactions = Transaction::query()->whereHas('reason', function ($q) {
            $q->whereIn('type', [ReasonType::BUY_CRYPTO, ReasonType::SELL_CRYPTO]);
        })->with('reason')->get();

        $coins = [];
        foreach ($transactions as $transaction) {
            $coin_name = $transaction->reason->coin_name;
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
