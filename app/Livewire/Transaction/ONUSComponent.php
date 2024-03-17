<?php

namespace App\Livewire\Transaction;

use App\Enums\ReasonType;
use App\Livewire\Forms\CashTransactionForm;
use App\Livewire\Forms\ONUSTransactionForm;
use App\Models\Reason;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class ONUSComponent extends BaseComponent
{

    public ?Transaction $transaction = null;
    public ONUSTransactionForm $form;

    public function render(): View
    {
        return $this->transaction
            ? view('livewire.transaction.show', ['page' => 'onus'])
            : view('livewire.transaction.onus-component');
    }

    public function mount(Transaction $transaction): void
    {
        if ($transaction->exists) {
            $this->transaction = $transaction->load('reason');
        } else {
            $this->loadMore();
        }
    }

    protected function getMoreTransactions($p): array
    {
        return Transaction::query()->whereNull('transaction_id')->with('reason')
            ->whereHas('reason', function ($q) {
                $q->whereIn('type', ReasonType::getFundExchangeReasonTypes());
            })
            ->orderByDesc('created_at')
            ->limit(10 * $p)
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->prettyCreatedAt;
            })->each(fn($transactions) => $transactions->each(fn($transaction) => $transaction->appendONUSData()))->toArray();
    }
}
