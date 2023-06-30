<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Reason;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{

    public function index(): View
    {
        $transactions = Transaction::query()->orderByDesc('created_at')->paginate(8);
        $reasons = Reason::query()->orderBy('name')->get();

        return view('transaction', [
            'transactions' => $transactions,
            'reasons' => $reasons,
        ]);
    }

    public function store(TransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $reason_id = isset($data['new_reason']) ?
            Reason::query()->create([
                'name' => $data['new_reason'],
                'label' => $data['new_reason_label'],
            ])->id : $data['reason_id'] ;

        Transaction::query()->create([
            'price' => $data['price'],
            'type' => $data['type'],
            'reason_id' => $reason_id,
            'created_at' => now(),
        ]);

        return redirect()->back();
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()->back();
    }

}
