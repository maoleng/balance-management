<?php

namespace App\Livewire\Transaction;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

abstract class BaseComponent extends Component
{

    public array $gr_transactions = [];
    public $cur_page = 1;

    public function loadMore(): void
    {
        $this->gr_transactions = $this->getMoreTransactions($this->cur_page);
        $this->cur_page++;
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

    public function destroy(Transaction $transaction, $route): void
    {
        $transaction->transactions()->delete();
        $transaction->delete();
        $this->redirectRoute($route, navigate: true);
    }

    abstract protected function getMoreTransactions($p): array;

}
