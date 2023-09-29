<?php

namespace App\Services\Statistics;

use App\Enums\ChartType;
use App\Enums\FilterTime;
use App\Enums\ReasonType;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ExpenseByReason
{

    public static function getExpenseByReason($time): array
    {
        $ranges = match ($time) {
            FilterTime::TODAY => [now()->startOfDay(), now()],
            FilterTime::THIS_WEEK => [now()->startOfWeek(), now()],
            FilterTime::THIS_MONTH => [now()->startOfMonth(), now()],
            FilterTime::THIS_YEAR => [now()->startOfYear(), now()],
            default => [now()->startOfCentury(), now()],
        };
        $q = DB::table('reasons')
            ->join('transactions', 'reasons.id', '=', 'transactions.reason_id')
            ->where('reasons.type', '=', ReasonType::SPEND)
            ->whereBetween('transactions.created_at', $ranges)
            ->select(
                'reasons.id',
                'reasons.name as reason',
                DB::raw('SUM(transactions.price * transactions.quantity) as money')
            )
        ;

        return [
            ChartType::TREE_MAP => self::getResultForTreeMapChart($q->clone()),
        ];
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

}
