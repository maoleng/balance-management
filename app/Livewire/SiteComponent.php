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
    public array $crypto_portfolio;
    public float $outstanding_credit;
    public float $outstanding_vib;
    public float $onus_balance;
    public float $outstanding_lio;

    public function render(): View
    {
        return view('livewire.site');
    }

    public function mount(): void
    {
        $cash_balance = CashFund::getBalance();
        $onus_balance = ONUSFund::getBalance();
        $crypto_fund = CryptoFund::getPortfolio();
        $crypto_balance = $crypto_fund['balance'];
        $crypto_portfolio = $crypto_fund['portfolio'];

        $this->overview = CashFund::getOverview();
        $this->outstanding_credit = CashFund::getOutstandingCredit();
        $this->outstanding_vib = CashFund::getOutstandingVIB();
        $this->outstanding_lio = CashFund::getOutstandingLIO();
        $this->cash_balance = $cash_balance;
        $this->crypto_balance = $crypto_balance;
        $this->crypto_portfolio = $crypto_portfolio;
        $this->onus_balance = $onus_balance;
        $this->balance = $cash_balance + $crypto_balance + $onus_balance;
    }

}
