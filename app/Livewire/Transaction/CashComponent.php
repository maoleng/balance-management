<?php

namespace App\Livewire\Transaction;

use App\Enums\ReasonType;
use App\Livewire\Forms\CashTransactionForm;
use App\Models\Reason;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class CashComponent extends Component
{
    public array $gr_transactions = [];
    public $cur_page = 1;
    public Collection $reasons;
    public CashTransactionForm $form;

    public function render(): View
    {
        return view('livewire.transaction.cash-component');
    }

    public function loadMore(): void
    {
        $this->gr_transactions = $this->getMoreTransactions($this->cur_page);
        $this->cur_page++;
    }

    public function mount(): void
    {
        $this->loadMore();
        $this->reasons = Reason::query()->orderBy('name')->get();
    }

    public function store(): void
    {
        $this->form->store();
    }

    private function getMoreTransactions($p): array
    {
        return Transaction::query()
            ->whereNull('transaction_id')
            ->with(['reason', 'transactions.reason'])
            ->whereHas('reason', function ($q) {
                $q->whereIn('type', array_merge(ReasonType::getCashReasonTypes(), [ReasonType::GROUP, ReasonType::CREDIT_SETTLEMENT]));
            })
            ->orderByDesc('created_at')
            ->limit(10 * $p)
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->isToday() ? 'Hôm nay' : Str::ucfirst($transaction->created_at->isoFormat('dddd')) . ', ' . $transaction->created_at->format('d-m-Y');
            })->each(function ($transactions) {
                $transactions->each(function ($transaction) {
                    $transaction->append('isCredit');
                    if ($transaction->reason->type === ReasonType::GROUP) {
                        $transaction->append('totalPrice');
                    }
                    $transaction->reason->append('shortName');
                });
            })->toArray();
    }
}
