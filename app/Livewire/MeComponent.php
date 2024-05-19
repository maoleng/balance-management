<?php

namespace App\Livewire;

use App\Services\Balance\CashFund;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class MeComponent extends Component
{

    public int $init;

    public function mount()
    {
        $this->init = (int) CashFund::getBalance();
    }

    public function render(): View
    {
        return view('livewire.me');
    }

    public function saveInitAmount(): void
    {
        $amount = (int) File::get('init.txt');
        $system_amount = (int) CashFund::getBalance();
        $real_amount = $this->init;

        if ($system_amount > $real_amount) {
            $amount -= $system_amount - $real_amount;
        } elseif ($system_amount < $real_amount) {
            $amount += $real_amount - $system_amount;
        }

        File::put('init.txt', $amount);
    }

    public function toggleDarkMode(): void
    {
        $dark_mode = Cache::get('dark-mode') === 'dark-mode' ? '' : 'dark-mode';
        Cache::forever('dark-mode', $dark_mode);
    }

}
