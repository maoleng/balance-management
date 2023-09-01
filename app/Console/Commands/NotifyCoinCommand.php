<?php

namespace App\Console\Commands;

use App\Http\Controllers\BalanceController;
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

        $content = "=========================\n";
        foreach ($notify_coins as $notify_coin) {
            $response = $client->get($endpoint.$notify_coin->coin.'USDT')->getBody()->getContents();
            $price = json_decode($response)->price;
            $profit = $notify_coin->coin_amount ?
                $notify_coin->coin_amount * (new BalanceController)->getRealMoneyOfCoin($notify_coin->coin) - $notify_coin->balance : 0;

            $btf_profit = number_format($profit).' VND';
            $btf_price = round($price, 8);

            $content .= $notify_coin->coin.'       '.$btf_price.'       '.$btf_profit."\n";
        }
        $content .= 'USDT       '.number_format((new BalanceController)->getRealMoneyOfCoin('USDT')).' VND';
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
