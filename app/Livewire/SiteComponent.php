<?php

namespace App\Livewire;

use App\Services\Balance\CashFund;
use App\Services\Balance\CryptoFund;
use App\Services\Balance\ONUSFund;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class SiteComponent extends Component
{

    public Model $overview;
    public mixed $balance;
    public float $cash_balance;
    public float $crypto_balance;
    public float $outstanding_credit;
    public float $outstanding_vib;
    public float $onus_balance;
    public mixed $onus_future_balance;
    public mixed $onus_farming_balance;

    public function render(): View
    {
        return view('livewire.site');
    }

    public function mount(): void
    {
        $cash_balance = CashFund::getBalance();
        $onus_balance = ONUSFund::getBalance();
        $onus_farming_balance = ONUSFund::getFarmingBalance();
        $onus_future_balance = ONUSFund::getFutureBalance();
        $crypto_balance = CryptoFund::getBalance();

        $this->overview = CashFund::getOverview();
        $this->outstanding_credit = CashFund::getOutstandingCredit();
        $this->outstanding_vib = CashFund::getOutstandingVIB();
        $this->cash_balance = $cash_balance;
        $this->crypto_balance = $crypto_balance;
        $this->onus_balance = $onus_balance;
        $this->onus_farming_balance = $onus_farming_balance;
        $this->onus_future_balance = $onus_future_balance;
        $this->balance = $cash_balance + $crypto_balance + $onus_balance + $onus_farming_balance + $onus_future_balance;
    }

}
