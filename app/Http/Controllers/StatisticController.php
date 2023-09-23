<?php

namespace App\Http\Controllers;

use App\Enums\FilterTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{

    public function index(Request $request): array
    {
        $time = $request->get('time');

        return $this->getMoneySpentByCategory($time);
    }

    public function expense(): View
    {
        return view('statistic.expense');
    }

    private function getMoneySpentByCategory($time): array
    {
        $ranges = match ($time) {
            FilterTime::TODAY => [now()->startOfDay(), now()],
            FilterTime::THIS_WEEK => [now()->startOfWeek(), now()],
            FilterTime::THIS_MONTH => [now()->startOfMonth(), now()],
            FilterTime::THIS_YEAR => [now()->startOfYear(), now()],
            default => [now()->subYears(100), now()],
        };
        $q = DB::table('categories')
            ->join('reasons', 'categories.id', '=', 'reasons.category_id')
            ->join('transactions', 'reasons.id', '=', 'transactions.reason_id')
            ->where('reasons.type', '=', 0)
            ->whereBetween('transactions.created_at', $ranges);
        $data = match ($time) {
            FilterTime::THIS_WEEK => $q->select(
                DB::raw('DATE(transactions.created_at) as time'),
                'categories.id',
                'categories.name as category',
                DB::raw('SUM(transactions.price * transactions.quantity) as money')
            )->groupBy('time', 'categories.id', 'categories.name')
                ->orderBy('time')
                ->get(),
            FilterTime::THIS_MONTH => $q->select(
                DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%u") as time'),
                'categories.id',
                'categories.name as category',
                DB::raw('SUM(transactions.price * transactions.quantity) as money')
            )->groupBy('time', 'categories.id', 'categories.name')->orderBy('time')->get(),
            FilterTime::THIS_YEAR => $q->select(
                DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m") as time'),
                'categories.id',
                'categories.name as category',
                DB::raw('SUM(transactions.price * transactions.quantity) as money')
            )
                ->groupBy('time', 'categories.id', 'categories.name')
                ->orderBy('time')
                ->get(),
            default => $q->select('categories.id', 'categories.name as category', DB::raw('SUM(transactions.price * transactions.quantity) as money'))
                ->groupBy('categories.id', 'categories.name')
                ->get(),
        };

        return $this->prettyResultForChart($data, $time);
    }

    private function prettyResultForChart(Collection $data, $filter_time): array
    {
        $times = $data->pluck('time')->unique();
        $times = match ($filter_time) {
            FilterTime::THIS_MONTH => $times->combine($times->map(function ($time) {
                [,$week] = explode('-', $time);
                $carbon_time = now()->startOfYear()->addWeeks($week);
                $start = $carbon_time->copy()->startOfWeek()->format('d-m');
                $end = $carbon_time->copy()->endOfWeek()->format('d-m');

                return "$start ~ $end";
            }))->toArray(),
            FilterTime::THIS_YEAR => $times->combine($times->map(function ($date) {
                return date("m-Y", strtotime($date));
            }))->toArray(),
            FilterTime::THIS_WEEK => $times->combine($times->map(function ($date) {
                return date("d-m", strtotime($date));
            }))->toArray(),
            FilterTime::TODAY => [null => 'Today'],
            default => [null => 'All'],
        };

        $formatted_data = $data->groupBy('category')->map(function ($money_group_by_date) use ($times) {
            $result = [];
            foreach ($times as $key => $time) {
                $money = $money_group_by_date->firstWhere('time', $key);
                $result[$time] = $money ? $money->money : 0;
            }

            return $result;
        })->toArray();

        $series = [];
        foreach ($formatted_data as $category => $moneys) {
            $series[] = [
                'name' => $category,
                'data' => array_values($moneys),
            ];
        }

        return [
            'series' => $series,
            'categories' => array_values($times),
        ];
    }

}
