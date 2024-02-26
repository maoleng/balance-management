<?php

namespace App\Livewire\Transaction;

use App\Enums\ReasonType;
use App\Livewire\Forms\CashTransactionForm;
use App\Models\Reason;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class CashComponent extends BaseComponent
{

    public ?Transaction $transaction = null;
    public Collection $reasons;
    public CashTransactionForm $form;

    public function render(): View
    {
        return $this->transaction
            ? view('livewire.transaction.show', ['page' => 'cash'])
            : view('livewire.transaction.cash-component');
    }

    public function mount(Transaction $transaction): void
    {
        if ($transaction->exists) {
            $this->transaction = $transaction->load(['reason.category', 'transactions.reason']);
        } else {
            $this->loadMore();
            $this->reasons = Reason::query()->orderBy('name')->get();
        }
    }

    protected function getMoreTransactions($p): array
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
                return $transaction->created_at->isToday() ? 'Hôm nay' : $transaction->prettyCreatedAt;
            })->each(fn($transactions) => $transactions->each(fn($transaction) => $transaction->appendCashData()))->toArray();
    }

}
