<?php

namespace App\Console\Commands;

use App\Services\Balance\CryptoFund;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class NotifyCoinCommand extends Command
{

    protected $signature = 'crypto:notify';
    protected $description = 'Notify coin every 5 mins';

    public function handle()
    {
        $client = new Client;
        $endpoint = 'https://api.binance.com/api/v3/ticker/price?symbol=';

        $coins = CryptoFund::getCoinsValue();
        $notify_coins = array_diff(explode(',', env('NOTIFY_COINS') ?? 'BTC'), array_keys($coins));

        $content = "=========================\n";
        foreach ($coins as $coin_name => $coin) {
            if ($coin['quantity'] > 0) {
                $price = json_decode($client->get($endpoint.$coin_name.'USDT')->getBody()->getContents())->price;
                $profit = $coin['quantity'] * CryptoFund::getRealMoneyOfCoin($coin_name) - $coin['price'];
                $btf_profit = number_format($profit).' VND';
                $btf_price = round($price, 8);
                $content .= $coin_name.'       '.$btf_price.'       '.$btf_profit."\n";
            }
        }
        foreach ($notify_coins as $coin_name) {
            $price = json_decode($client->get($endpoint.$coin_name.'USDT')->getBody()->getContents())->price;
            $btf_price = round($price, 8);
            $content .= $coin_name.'       '.$btf_price."\n";
        }
        $content .= 'USDT       '.number_format(CryptoFund::getRealMoneyOfCoin('USDT')).' VND';
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

}
