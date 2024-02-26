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

    public function store(CashTransactionRequest $request): RedirectResponse
    {


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
