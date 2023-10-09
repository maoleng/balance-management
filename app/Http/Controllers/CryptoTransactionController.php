<?php

namespace App\Http\Controllers;

use App\Enums\ReasonType;
use App\Http\Requests\CryptoTransactionRequest;
use App\Models\Reason;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CryptoTransactionController extends Controller
{

    public function index(): View
    {
        $transactions = Transaction::query()->whereNull('transaction_id')->with('reason')
            ->whereHas('reason', function ($q) {
                $q->whereIn('type', [ReasonType::BUY_CRYPTO, ReasonType::SELL_CRYPTO]);
            })
            ->orderByDesc('created_at')->paginate(8);

        return view('transaction.crypto.index', [
            'transactions' => $transactions,
        ]);
    }

    public function store(CryptoTransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $reason_name = ReasonType::getDescription((int) $data['type']);

        $reason_id = Reason::query()->firstOrCreate(
            [
                'name' => $reason_name,
            ],
            [
                'name' => $reason_name,
                'type' => $data['type'],
            ]
        )->id;

        Transaction::query()->create([
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'reason_id' => $reason_id,
            'external' => ['coin' => $data['name']],
            'created_at' => now(),
        ]);

        return back()->with('success', 'Create transaction successfully');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return back()->with('success', 'Delete transaction successfully');
    }

}
