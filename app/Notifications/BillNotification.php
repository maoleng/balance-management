<?php

namespace App\Notifications;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class BillNotification extends Notification
{
    use Queueable;

    private Bill $bill;

    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    public function via(): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush(): WebPushMessage
    {
        $money = number_format($this->bill->price).'đ';

        return (new WebPushMessage)
            ->title('Hóa đơn cần thanh toán')
            ->icon(asset('assets/img/icon/192x192.png'))
            ->badge(asset('assets/img/icon/96x96.png'))
            ->body("Cần thanh toán $money cho tiền {$this->bill->name} trong {$this->bill->payDayLeft} nữa.");
    }

}
