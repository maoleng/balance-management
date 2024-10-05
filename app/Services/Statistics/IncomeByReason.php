<?php

namespace App\Services\Statistics;

use App\Enums\ChartType;
use App\Enums\FilterTime;
use App\Enums\ReasonType;
use App\Models\Reason;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class IncomeByReason
{

    public static function getIncomeByReason($time): array
    {
        $q = Reason::query()
            ->join('transactions', 'reasons.id', '=', 'transactions.reason_id')
            ->whereIn('reasons.type', [ReasonType::EARN, ReasonType::DAILY_REVENUE_ONUS])
            ->whereBetween('transactions.created_at', FilterTime::getRanges($time))
            ->whereNull('deleted_at')
            ->select(
                'reasons.id',
                'reasons.name as reason',
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
        $data = $q->addSelect('reasons.image')->groupBy('reasons.id', 'reasons.name')->get();
        $result = [
            'series' => [],
            'labels' => [],
            'colors' => [],
            'images' => [],
        ];

        foreach ($data as $each) {
            $result['series'][] = $each->money;
            $result['labels'][] = $each->reason;
            $result['colors'][] = $faker->hexColor;
            $result['images'][] = getFullPath($each->image);
        }

        return $result;
    }

    private static function getResultForTreeMapChart(Builder $q): array
    {
        $faker = Faker::create();
        $data = $q->groupBy('reasons.id', 'reasons.name')->get();
        $result = [];
        $colors = [];
        foreach ($data as $each) {
            $colors[] = $faker->hexColor;
            $result[] = [
                'x' => $each->reason,
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
            )->groupBy('time', 'reasons.id', 'reasons.name')->orderBy('time')->get(),
            FilterTime::THIS_MONTH => $q->addSelect(
                DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%u") as time'),
            )->groupBy('time', 'reasons.id', 'reasons.name')->orderBy('time')->get(),
            FilterTime::THIS_YEAR => $q->addSelect(
                DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m") as time'),
            )->groupBy('time', 'reasons.id', 'reasons.name')->orderBy('time')->get(),
            default => $q->groupBy('reasons.id', 'reasons.name')->get(),
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

        $formatted_data = $data->groupBy('reason')->map(function ($money_group_by_date) use ($times) {
            $result = [];
            foreach ($times as $key => $time) {
                $money = $money_group_by_date->firstWhere('time', $key);
                $result[$time] = $money ? $money->money : 0;
            }

            return $result;
        })->toArray();

        $series = [];
        foreach ($formatted_data as $reason => $moneys) {
            $series[] = [
                'name' => $reason,
                'data' => array_values($moneys),
            ];
        }

        return [
            'series' => $series,
            'categories' => array_values($times),
        ];
    }

}
