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
        $transactions = Transaction::query()->with('reason')->orderByDesc('created_at')->paginate(8);
        $reasons = Reason::query()->orderBy('name')->get();

        return view('transaction.index', [
            'transactions' => $transactions,
            'reasons' => $reasons,
        ]);
    }

    public function store(TransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if ($data['type'] === null) {
            $reason_id = null;
        } elseif (isset($data['reason_id'])) {
            $reason_id = $data['reason_id'];
        } else {
            $reason_id = Reason::query()->firstOrCreate(
                [
                    'name' => $data['new_reason'],
                ],
                [
                    'name' => $data['new_reason'],
                    'label' => $data['new_reason_label'],
                    'is_group' => false,
                ]
            )->id;
        }

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
