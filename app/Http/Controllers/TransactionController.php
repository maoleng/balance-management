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
        $reasons = Reason::query()->get();

        return view('transaction', [
            'transactions' => $transactions,
            'reasons' => $reasons,
        ]);
    }

    public function store(TransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Transaction::query()->create([
            'price' => $data['price'],
            'type' => $data['type'],
            'reason_id' => $data['reason_id'],
            'created_at' => now(),
        ]);

        return redirect()->back();
    }

}
