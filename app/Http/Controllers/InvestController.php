<?php

namespace App\Http\Controllers;

use App\Models\NotifyCoin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvestController extends Controller
{

    public function index(): View
    {
        $notify_coins = NotifyCoin::query()->get();

        return view('invest', [
            'notify_coins' => $notify_coins,
        ]);
    }

    public function update(Request $request, NotifyCoin $notify_coin): RedirectResponse
    {
        $data = $request->all();
        $notify_coin->update([
            'coin_amount' => $data['coin_amount'],
            'balance' => $data['balance'],
        ]);

        return redirect()->back();
    }

}
