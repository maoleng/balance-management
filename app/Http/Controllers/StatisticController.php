<?php

namespace App\Http\Controllers;

use App\Enums\ChartType;
use App\Services\Statistics\ExpenseByCategory;
use App\Services\Statistics\IncomeByReason;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StatisticController extends Controller
{

    public function index(Request $request): array
    {
        return match ($request->get('type')) {
            'expense' => ExpenseByCategory::getExpenseByCategory($request->get('time')),
            'income' => IncomeByReason::getIncomeByReason($request->get('time')),
        };
    }

    public function expense(): View
    {
        return view('statistic.expense');
    }

    public function income(): View
    {
        return view('statistic.income');
    }

}
