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

    private string $left;
    private string $outstanding;

    public function __construct($left, $outstanding)
    {
        $this->left = $left;
        $this->outstanding = $outstanding;
    }

    public function via(): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush(): WebPushMessage
    {
        return (new WebPushMessage)
            ->title('Dư nợ tín dụng')
            ->icon(asset('assets/img/icon/192x192.png'))
            ->badge(asset('assets/img/icon/96x96.png'))
            ->body("$this->left. \n$this->outstanding");
    }

}
