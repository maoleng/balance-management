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

    public function store(CryptoTransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        return back()->with('success', 'Create transaction successfully');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return back()->with('success', 'Delete transaction successfully');
    }

}
