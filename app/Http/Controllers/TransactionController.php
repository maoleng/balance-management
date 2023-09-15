<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Requests\UpdateGroupTransactionRequest;
use App\Models\Reason;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{

    public function index(): View
    {
        $transactions = Transaction::query()->whereNull('transaction_id')
            ->with(['reason', 'transactions.reason'])->orderByDesc('created_at')->paginate(8);
        $reasons = Reason::query()->orderBy('name')->get();

        return view('transaction.index', [
            'transactions' => $transactions,
            'reasons' => $reasons,
        ]);
    }

    public function store(TransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $reason_id = Reason::query()->firstOrCreate(
            [
                'name' => $data['reason']
            ],
            [
                'name' => $data['reason'],
                'type' => $data['type'],
            ]
        )->id;

        Transaction::query()->create([
            'price' => $data['price'],
            'reason_id' => $reason_id,
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

        Transaction::query()->where('transaction_id', $data['transaction_id'])
            ->whereNotIn('id', $data['transaction_ids'] ?? [])->delete();

        $transactions = $request->get('transactions') ?? [];
        foreach ($transactions as $transaction) {
            $data = [
                'price' => $transaction['price'],
                'quantity' => $transaction['quantity'],
                'reason_id' => $transaction['reason_id'],
                'transaction_id' => $data['transaction_id'],
                'created_at' => $request->get('transaction')->created_at,
            ];

            Transaction::query()->updateOrInsert(['id' => $transaction['id']], $data);
        }

        return back()->with('success', 'Update transaction successfully');
    }

}
