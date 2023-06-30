<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\View\View;

class TransactionController extends Controller
{

    public function index(): View
    {
        $transactions = Transaction::query()->paginate(8);

        return view('transaction', [
            'transactions' => $transactions,
        ]);
    }

}
