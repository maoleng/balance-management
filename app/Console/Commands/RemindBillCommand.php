<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\User;
use App\Notifications\BillNotification;
use Illuminate\Console\Command;

class RemindBillCommand extends Command
{

    protected $signature = 'bill:remind';

    public function handle(): void
    {
        $user = User::query()->where('email', env('AUTH_EMAIL'))->first();
        $bills = Bill::query()->whereBetween('pay_at', [now(), now()->addDays(7)])->get();
        foreach ($bills as $bill) {
            $user->notify(new BillNotification($bill));
        }
    }

}
