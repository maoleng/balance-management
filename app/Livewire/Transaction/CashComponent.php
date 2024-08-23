<?php

namespace App\Livewire\Transaction;

use App\Enums\ReasonType;
use App\Livewire\Forms\CashGroupTransactionForm;
use App\Livewire\Forms\CashTransactionForm;
use App\Models\Reason;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class CashComponent extends BaseComponent
{

    public ?Transaction $transaction = null;
    public Collection $reasons;
    public Collection $transactions;
    public CashTransactionForm $form;
    public CashGroupTransactionForm $group_form;

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
            $this->transactions = $transaction->transactions;
            $this->reasons = Reason::query()->where('type', ReasonType::SPEND)
                ->whereNotIn('id', $this->transactions->pluck('reason.id')->toArray())->orderBy('name')->get();
        } else {
            $this->loadMore();
            $this->reasons = Reason::query()->orderBy('name')->get();
        }
    }

    public function storeGroup(): void
    {
        $transaction = $this->group_form->store($this->transaction);
        $this->transactions->push($transaction);
    }

    public $date;

    public $time;

    public function updateTime(): void
    {
        $this->transaction->update(['created_at' => $this->date.$this->time]);
    }

    public function destroyGroup($transaction_id): void
    {
        Transaction::query()->find($transaction_id)->delete();
        $this->transactions = $this->transactions->except($transaction_id);
        $this->reasons = Reason::query()->where('type', ReasonType::SPEND)
            ->whereNotIn('id', $this->transactions->pluck('reason.id')->toArray())->orderBy('name')->get();
    }

    protected function getMoreTransactions($p): array
    {
        return Transaction::query()
            ->whereNull('transaction_id')
            ->with(['reason', 'transactions.reason'])
            ->whereHas('reason', function ($q) {
                $q->whereIn('type', array_merge(ReasonType::getCashReasonTypes(), [
                    ReasonType::GROUP, ReasonType::CREDIT_SETTLEMENT, ReasonType::VIB_SETTLEMENT,
                ]));
            })
            ->orderByDesc('created_at')
            ->limit(10 * $p)
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->prettyCreatedAt;
            })->each(fn($transactions) => $transactions->each(fn($transaction) => $transaction->appendCashData()))->toArray();
    }

}
