<?php

namespace App\Livewire\Transaction;

use App\Enums\ReasonType;
use App\Livewire\Forms\CashTransactionForm;
use App\Livewire\Forms\CryptoTransactionForm;
use App\Models\Reason;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class CryptoComponent extends Component
{
    public array $gr_transactions = [];
    public $cur_page = 1;
    public $no_more_transactions = false;
    public CryptoTransactionForm $form;

    public function render(): View
    {
        return view('livewire.transaction.crypto-component');
    }

    public function loadMore(): void
    {
        $this->gr_transactions = $this->getMoreTransactions($this->cur_page);
        $this->cur_page++;
    }

    public function mount(): void
    {
        $this->loadMore();
    }

    public function store(): void
    {
        $transaction = $this->form->store();
        if (empty($this->gr_transactions['Hôm nay'])) {
            $this->gr_transactions = ['Hôm nay' => [$transaction]] + $this->gr_transactions;
        } else {
            array_unshift($this->gr_transactions['Hôm nay'], $transaction);
        }
    }

    private function getMoreTransactions($p): array
    {
        return Transaction::query()->whereNull('transaction_id')->with('reason')
            ->whereHas('reason', function ($q) {
                $q->whereIn('type', [ReasonType::BUY_CRYPTO, ReasonType::SELL_CRYPTO]);
            })
            ->orderByDesc('created_at')
            ->limit(10 * $p)
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->isToday() ? 'Hôm nay' : Str::ucfirst($transaction->created_at->isoFormat('dddd')).', '.$transaction->created_at->format('d-m-Y');
            })->each(fn($transactions) => $transactions->each(fn($transaction) => $transaction->appendCryptoData()))->toArray();
    }
}
