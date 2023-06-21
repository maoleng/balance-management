<?php

namespace App\Console\Commands;

use App\Models\CoinPrice;
use App\Models\NotifyCoin;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class NotifyCoinCommand extends Command
{

    protected $signature = 'notify-coin';
    protected $description = 'Notify coin every 5 mins';

    public function handle()
    {
        $client = new Client;
        $endpoint = 'https://api.binance.com/api/v3/ticker/price?symbol=';

        $notify_coins = NotifyCoin::query()->get();
        $coin_prices = [];

        $content = "=========================\n";
        foreach ($notify_coins as $notify_coin) {
            $response = $client->get($endpoint.$notify_coin->coin.'USDT')->getBody()->getContents();
            $price = json_decode($response)->price;
            if ($notify_coin->coin_amount) {
                $profit = $notify_coin->coin_amount * $this->getRealMoneyOfCoin($notify_coin->coin) - $notify_coin->balance;
                $coin_prices[] = [
                    'coin' => $notify_coin->coin,
                    'price' => $price,
                    'profit' => $profit,
                    'created_at' => now(),
                ];
            } else {
                $profit = 0;
            }

            $btf_profit = number_format($profit).' VND';
            $btf_price = round($price, 8);

            $content .= $notify_coin->coin.'       '.$btf_price.'       '.$btf_profit."\n";
        }
        $content .= 'USDT       '.number_format($this->getRealMoneyOfCoin('USDT')).' VND';
        CoinPrice::query()->insert($coin_prices);
        (new Client)->post(env('ENDPOINT_TELEGRAM_LOG_MESSAGE'), [
            'verify' => false,
            'headers' => [
                'token' => env('COIN_NOTIFY_SECRET_KEY'),
            ],
            'json' => [
                'channel_uuid' => env('COIN_NOTIFY_CHANNEL_ID'),
                'content' => $content,
                'parse_mode' => 'HTML',
            ],
        ]);
    }

    private function getRealMoneyOfCoin($coin): float
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
