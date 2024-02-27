<?php

namespace App\Livewire;

use App\Services\Statistics\ExpenseByCategory;
use App\Services\Statistics\ExpenseByLabel;
use App\Services\Statistics\ExpenseByReason;
use App\Services\Statistics\IncomeByReason;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Livewire\Component;

class StatisticComponent extends Component
{

    public function render(Request $request): View
    {
        $p = $request->get('p');
        if ($p !== 'expense' && $p !== 'income') {
            $p = 'index';
        }

        return view("livewire.statistic.$p");
    }

    public function fetch(Request $request): array
    {
        return match ($request->get('type')) {
            'expense-category' => ExpenseByCategory::getExpenseByCategory($request->get('time')),
            'expense-reason' => ExpenseByReason::getExpenseByReason($request->get('time')),
            'income' => IncomeByReason::getIncomeByReason($request->get('time')),
            'expense-label' => ExpenseByLabel::getExpenseLabel($request->get('time')),
        };
    }

}
