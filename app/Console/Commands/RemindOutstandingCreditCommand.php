<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\CreditNotification;
use App\Services\Balance\CashFund;
use Illuminate\Console\Command;

class RemindOutstandingCreditCommand extends Command
{

    protected $signature = 'credit:remind';

    protected $description = 'Nhắc nhở tín dụng';

    public function handle(): void
    {
        $user = User::query()->where('email', env('AUTH_EMAIL'))->first();

        $credit_outstanding = CashFund::getOutstandingCredit();
        $vib_outstanding = CashFund::getOutstandingVIB();
        $lio_outstanding = CashFund::getOutstandingLIO();
        $momo = number_format(-$credit_outstanding).'đ';
        $vib = number_format(-$vib_outstanding).'đ';
        $lio = number_format(-$lio_outstanding).'đ';

        $day = now()->day;
        $end_of_month_day = now()->endOfMonth()->day;
        $left = '';
        $outstanding = '';
        if ($day >= 3 && $day <= 10) {
            $day_left = 10 - $day;
            if ($credit_outstanding > 0) {
                $left .= "Còn $day_left ngày nữa là tới hạn thanh toán Ví trả sau.\n";
                $outstanding .= "Dư nợ Ví trả sau là $momo.\n";
            }
            if ($vib_outstanding > 0) {
                $left .= "Còn $day_left ngày nữa là tới hạn thanh toán Thẻ tín dụng VIB.\n";
                $outstanding .= "Dư nợ Thẻ tín dụng VIB là $vib.\n";
            }
        } elseif ($day <= $end_of_month_day && $day >= $end_of_month_day - 7 && $lio_outstanding > 0) {
            $left = 'Còn '.($end_of_month_day - $day).' ngày nữa là tới hạn thanh toán Thẻ tín dụng LIO.';
            $outstanding = "Dư nợ Thẻ tín dụng LIO là $lio.";
        }

        if ($left === '' || $outstanding === '') {
            return;
        }

        $user->notify(new CreditNotification($left, $outstanding));
    }
}
