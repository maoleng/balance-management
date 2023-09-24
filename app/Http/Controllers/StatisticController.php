<?php

namespace App\Http\Controllers;

use App\Traits\Statistics\MoneySpentByCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StatisticController extends Controller
{

    use MoneySpentByCategory;

    public function index(Request $request): array
    {
        return $this->getMoneySpentByCategory($request->get('time'));
    }

    public function expense(): View
    {
        return view('statistic.expense');
    }

}
