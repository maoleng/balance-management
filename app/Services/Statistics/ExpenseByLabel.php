<?php

namespace App\Services\Statistics;

use App\Enums\ChartType;
use App\Enums\FilterTime;
use App\Enums\ReasonLabel;
use App\Enums\ReasonType;
use App\Models\Transaction;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ExpenseByLabel
{

    public static function getExpenseLabel($time): array
    {
        $q = Transaction::query()
            ->join('reasons', 'reasons.id', '=', 'transactions.reason_id')
            ->where('reasons.type', '=', ReasonType::SPEND)
            ->whereBetween('created_at', FilterTime::getRanges($time))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COALESCE(label, "null") as label'),
                DB::raw('SUM(transactions.price * transactions.quantity) as money')
            )
            ->groupBy('date', 'reasons.label')
            ->orderBy('date');

        return [
            ChartType::STACKED_AREA => self::getResultForStackedAreaChart($q),
        ];
    }

    public static function getResultForStackedAreaChart(Builder $q): array
    {
        $data = $q->get();
        if ($data->isEmpty()) {
            return [];
        }
        $dates = CarbonPeriod::create($data[0]->date, $data->last()->date)->toArray();
        $result = [];

        foreach ($dates as $date) {
            $timestamp = $date->timestamp * 1000 + 25200000;
            foreach ($data as $each) {
                $result[ReasonLabel::MUST_HAVE][$each->date][0] = $timestamp;
                $result[ReasonLabel::NICE_TO_HAVE][$each->date][0] = $timestamp;
                $result[ReasonLabel::WASTE][$each->date][0] = $timestamp;
                if (! isset($result[ReasonLabel::MUST_HAVE][$each->date][1])) {
                    $result[ReasonLabel::MUST_HAVE][$each->date][1] = 0;
                }
                if (! isset($result[ReasonLabel::NICE_TO_HAVE][$each->date][1])) {
                    $result[ReasonLabel::NICE_TO_HAVE][$each->date][1] = 0;
                }
                if (! isset($result[ReasonLabel::WASTE][$each->date][1])) {
                    $result[ReasonLabel::WASTE][$each->date][1] = 0;
                }
                if ($date->eq($each->date)) {
                    $result[(int) $each->label][$each->date][1] = (int) $data->shift()->money;
                }
            }
        }

        return [
            [
                'name' => 'MUST_HAVE',
                'data' => array_values($result[ReasonLabel::MUST_HAVE]),
            ],
            [
                'name' => 'NICE_TO_HAVE',
                'data' => array_values($result[ReasonLabel::NICE_TO_HAVE]),
            ],
            [
                'name' => 'WASTE',
                'data' => array_values($result[ReasonLabel::WASTE]),
            ],
        ];
    }

}
