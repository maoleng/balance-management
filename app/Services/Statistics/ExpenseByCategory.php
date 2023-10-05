<?php

namespace App\Services\Statistics;

use App\Enums\ChartType;
use App\Enums\FilterTime;
use App\Enums\ReasonType;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ExpenseByCategory
{

    public static function getExpenseByCategory($time): array
    {
        $q = DB::table('categories')
            ->join('reasons', 'categories.id', '=', 'reasons.category_id')
            ->join('transactions', 'reasons.id', '=', 'transactions.reason_id')
            ->where('reasons.type', '=', ReasonType::SPEND)
            ->whereBetween('transactions.created_at', FilterTime::getRanges($time))
            ->select(
                'categories.id',
                'categories.name as category',
                DB::raw('SUM(transactions.price * transactions.quantity) as money')
            )
        ;

        return [
            ChartType::STACKED_BAR => self::getResultForStackedBarChart($q->clone(), $time),
            ChartType::TREE_MAP => self::getResultForTreeMapChart($q->clone()),
            ChartType::PIE => self::getResultForPieChart($q->clone()),
        ];
    }

    private static function getResultForPieChart(Builder $q): array
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

    private static function getResultForTreeMapChart(Builder $q): array
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

    private static function getResultForStackedBarChart(Builder $q, $time): array
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
