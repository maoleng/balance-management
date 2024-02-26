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

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return back()->with('success', 'Delete transaction successfully');
    }

}
