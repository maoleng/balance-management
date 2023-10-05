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
        $q = DB::table('reasons')
            ->join('transactions', 'reasons.id', '=', 'transactions.reason_id')
            ->where('reasons.type', '=', ReasonType::SPEND)
            ->whereBetween('transactions.created_at', FilterTime::getRanges($time))
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
