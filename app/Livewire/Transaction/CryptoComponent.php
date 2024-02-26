<?php

namespace App\Livewire\Transaction;

use App\Enums\ReasonType;
use App\Livewire\Forms\CryptoTransactionForm;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class CryptoComponent extends BaseComponent
{

    public ?Transaction $transaction = null;
    public CryptoTransactionForm $form;

    public function render(): View
    {
        return $this->transaction
            ? view('livewire.transaction.show', ['page' => 'crypto'])
            : view('livewire.transaction.crypto-component');
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
                $q->whereIn('type', [ReasonType::BUY_CRYPTO, ReasonType::SELL_CRYPTO]);
            })
            ->orderByDesc('created_at')
            ->limit(10 * $p)
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->isToday() ? 'Hôm nay' : $transaction->prettyCreatedAt;
            })->each(fn($transactions) => $transactions->each(fn($transaction) => $transaction->appendCryptoData()))->toArray();
    }
}
