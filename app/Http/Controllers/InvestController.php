<?php

namespace App\Http\Controllers;

use App\Models\NotifyCoin;
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

}
