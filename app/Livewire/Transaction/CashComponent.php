<?php

namespace App\Livewire\Transaction;

use App\Enums\ReasonType;
use App\Livewire\Forms\CashTransactionForm;
use App\Models\Reason;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CashComponent extends Component
{
    public Collection $reasons;
    public CashTransactionForm $form;

    public function render(): View
    {
        return view('livewire.transaction.cash-component');
    }

    #[Computed]
    public function gr_transactions()
    {
        return Transaction::query()
            ->whereNull('transaction_id')
            ->with(['reason', 'transactions.reason'])
            ->whereHas('reason', function ($q) {
                $q->whereIn('type', array_merge(ReasonType::getCashReasonTypes(), [ReasonType::GROUP, ReasonType::CREDIT_SETTLEMENT]));
            })
            ->orderByDesc('created_at')
            ->skip((request()->get('page', 1) - 1) * 8)
            ->take(8)
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->isToday() ? 'Hôm nay' : Str::ucfirst($transaction->created_at->isoFormat('dddd')) . ', ' . $transaction->created_at->format('d-m-Y');
            });
    }


    public function mount(): void
    {
        $this->reasons = Reason::query()->orderBy('name')->get();
    }

    public function store(): void
    {
        $this->form->store();
    }

}
