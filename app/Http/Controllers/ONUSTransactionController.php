<?php

namespace App\Http\Controllers;

use App\Enums\ReasonType;
use App\Http\Requests\ONUSTransactionRequest;
use App\Models\Reason;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ONUSTransactionController extends Controller
{

    public function index(): View
    {
        $transactions = Transaction::query()->whereNull('transaction_id')->with('reason')
            ->whereHas('reason', function ($q) {
                $q->whereIn('type', ReasonType::getFundExchangeReasonTypes());
            })
            ->orderByDesc('created_at')->paginate(8);

        return view('transaction.onus.index', [
            'transactions' => $transactions,
        ]);
    }

    public function store(ONUSTransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $reason_id = Reason::query()->firstOrCreate(
            [
                'type' => $data['type'],
            ],
            [
                'name' => ReasonType::getDescription((int) $data['type']),
                'type' => $data['type'],
            ]
        )->id;

        $coin = $data['coin'] ?? null;
        Transaction::query()->create([
            'price' => $data['price'],
            'reason_id' => $reason_id,
            'external' => $coin ? ['coin' => $coin] : null,
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
