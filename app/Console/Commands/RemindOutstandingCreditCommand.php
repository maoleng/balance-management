<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\CreditNotification;
use Illuminate\Console\Command;

class RemindOutstandingCreditCommand extends Command
{

    protected $signature = 'credit:remind';

    protected $description = 'Nhắc nhở tín dụng';

    public function handle(): void
    {
        $user = User::query()->where('email', env('AUTH_EMAIL'))->first();
        $user->notify(new CreditNotification());
    }
}
