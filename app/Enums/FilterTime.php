<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use Carbon\CarbonPeriod;

final class FilterTime extends Enum
{

    public const TODAY = 'today';
    public const THIS_WEEK = 'this-week';
    public const THIS_MONTH = 'this-month';
    public const THIS_YEAR = 'this-year';

    public static function getRanges($time): array
    {
        return match ($time) {
            self::TODAY => [now()->startOfDay(), now()],
            self::THIS_WEEK => [now()->startOfWeek(), now()],
            self::THIS_MONTH => [now()->startOfMonth(), now()],
            self::THIS_YEAR => [now()->startOfYear(), now()],
            default => [now()->startOfCentury(), now()],
        };
    }

}
