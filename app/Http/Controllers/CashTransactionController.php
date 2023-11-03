<?php

namespace App\Http\Controllers;

use App\Enums\ReasonType;
use App\Http\Requests\CashTransactionRequest;
use App\Http\Requests\UpdateGroupTransactionRequest;
use App\Models\Reason;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CashTransactionController extends Controller
{

    public function index(): View
    {
        $transactions = Transaction::query()->whereNull('transaction_id')->with(['reason', 'transactions.reason'])
            ->whereHas('reason', function ($q) {
                $q->whereIn('type', array_merge(ReasonType::getCashReasonTypes(), [ReasonType::CREDIT_SETTLEMENT]));
            })
            ->orderByDesc('created_at')->paginate(8);
        $reasons = Reason::query()->orderBy('name')->get();

        return view('transaction.cash.index', [
            'transactions' => $transactions,
            'reasons' => $reasons,
        ]);
    }

    public function store(CashTransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $name = $data['reason'] ?? ReasonType::getDescription((int) $data['type']);
        $reason_id = Reason::query()->firstOrCreate(
            [
                'name' => $name,
            ],
            [
                'name' => $name,
                'type' => $data['type'],
            ]
        )->id;

        Transaction::query()->create([
            'price' => $data['price'],
            'reason_id' => $reason_id,
            'external' => $data['is_credit'] ? ['is_credit' => true] : null,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Create transaction successfully');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $check = $transaction->transactions->isNotEmpty();
        if ($check) {
            return back()->with('errors', 'This transaction has many children transactions, please delete it first');
        }

        $transaction->transactions()->delete();
        $transaction->delete();

        return back()->with('success', 'Delete transaction successfully');
    }

    public function updateGroupTransaction(UpdateGroupTransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $parent_transaction = $request->get('transaction');

        $transactions = $request->get('transactions') ?? [];
        foreach ($transactions as $transaction) {
            $data = [
                'price' => $transaction['price'],
                'quantity' => $transaction['quantity'],
                'reason_id' => $transaction['reason_id'],
                'external' => $parent_transaction->isCredit ? ['is_credit' => true] : null,
                'transaction_id' => $data['transaction_id'],
                'created_at' => $parent_transaction->created_at,
            ];

            Transaction::query()->updateOrCreate(['id' => $transaction['id']], $data);
        }

        return back()->with('success', 'Update transaction successfully');
    }

}
