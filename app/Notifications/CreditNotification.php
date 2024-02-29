<?php

namespace App\Notifications;

use App\Models\Bill;
use App\Services\Balance\CashFund;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreditNotification extends Notification
{
    use Queueable;

    public function via(): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush(): WebPushMessage
    {
        $money = number_format(-CashFund::getOutstandingCredit()).'đ';

        return (new WebPushMessage)
            ->title('Dư nợ tín dụng')
            ->icon(asset('assets/img/icon/192x192.png'))
            ->badge(asset('assets/img/icon/96x96.png'))
            ->body("Bạn đang có dư nợ tín dụng là $money.");
    }

}
