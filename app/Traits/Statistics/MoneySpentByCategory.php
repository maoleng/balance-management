<?php

namespace App\Traits\Statistics;

use App\Enums\ChartType;
use App\Enums\FilterTime;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

trait MoneySpentByCategory
{

    private function getMoneySpentByCategory($time): array
    {
        $ranges = match ($time) {
            FilterTime::TODAY => [now()->startOfDay(), now()],
            FilterTime::THIS_WEEK => [now()->startOfWeek(), now()],
            FilterTime::THIS_MONTH => [now()->startOfMonth(), now()],
            FilterTime::THIS_YEAR => [now()->startOfYear(), now()],
            default => [now()->startOfCentury(), now()],
        };
        $q = DB::table('categories')
            ->join('reasons', 'categories.id', '=', 'reasons.category_id')
            ->join('transactions', 'reasons.id', '=', 'transactions.reason_id')
            ->where('reasons.type', '=', 0)
            ->whereBetween('transactions.created_at', $ranges)
            ->select(
                'categories.id',
                'categories.name as category',
                DB::raw('SUM(transactions.price * transactions.quantity) as money')
            )
        ;

        return [
            ChartType::STACKED_BAR => $this->getResultForStackedBarChart($q->clone(), $time),
            ChartType::TREE_MAP => $this->getResultForTreeMapChart($q->clone()),
            ChartType::PIE => $this->getResultForPieChart($q->clone()),
        ];
    }

    private function getResultForPieChart(Builder $q): array
    {
        $faker = Faker::create();
        $data = $q->groupBy('categories.id', 'categories.name')->get();
        $result = [
            'series' => [],
            'labels' => [],
            'colors' => [],
            'images' => [],
        ];

        foreach ($data as $each) {
            $result['series'][] = $each->money;
            $result['labels'][] = $each->category;
            $result['colors'][] = $faker->hexColor;
            $result['images'][] = $faker->imageUrl;
        }

        return $result;
    }

    private function getResultForTreeMapChart(Builder $q): array
    {
        $faker = Faker::create();
        $data = $q->groupBy('categories.id', 'categories.name')->get();
        $result = [];
        $colors = [];
        foreach ($data as $each) {
            $colors[] = $faker->hexColor;
            $result[] = [
                'x' => $each->category,
                'y' => $each->money,
            ];
        }

        return [
            'series' => [
                ['data' => $result]
            ],
            'colors' => $colors,
        ];
    }

    private function getResultForStackedBarChart(Builder $q, $time): array
    {
        $data = match ($time) {
            FilterTime::THIS_WEEK => $q->addSelect(
                DB::raw('DATE(transactions.created_at) as time'),
            )->groupBy('time', 'categories.id', 'categories.name')->orderBy('time')->get(),
            FilterTime::THIS_MONTH => $q->addSelect(
                DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%u") as time'),
            )->groupBy('time', 'categories.id', 'categories.name')->orderBy('time')->get(),
            FilterTime::THIS_YEAR => $q->addSelect(
                DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m") as time'),
            )->groupBy('time', 'categories.id', 'categories.name')->orderBy('time')->get(),
            default => $q->groupBy('categories.id', 'categories.name')->get(),
        };
        $times = $data->pluck('time')->unique();
        $times = match ($time) {
            FilterTime::THIS_MONTH => $times->combine($times->map(function ($time) {
                [,$week] = explode('-', $time);
                $carbon_time = now()->startOfYear()->addWeeks($week);
                $start = $carbon_time->copy()->startOfWeek()->format('d-m');
                $end = $carbon_time->copy()->endOfWeek()->format('d-m');

                return "$start ~ $end";
            }))->toArray(),
            FilterTime::THIS_YEAR => $times->combine($times->map(function ($date) {
                return date('m-Y', strtotime($date));
            }))->toArray(),
            FilterTime::THIS_WEEK => $times->combine($times->map(function ($date) {
                return date('d-m', strtotime($date));
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
