<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class ReasonType extends Enum
{

    public const SPEND = 0;
    public const EARN = 1;
    public const GROUP = 2;
    public const CASH_TO_ONUS = 3;
    public const DAILY_REVENUE_ONUS = 4;
    public const FARM_REVENUE_ONUS = 5;
    public const ONUS_TO_CASH = 6;

    public static function getCashReasonTypes(): array
    {
        return [
            ReasonType::SPEND, ReasonType::EARN, ReasonType::GROUP,
        ];
    }

    public static function getFundExchangeReasonTypes(): array
    {
        return [
            'CASH_TO_ONUS' => ReasonType::CASH_TO_ONUS,
            'DAILY_REVENUE_ONUS' => ReasonType::DAILY_REVENUE_ONUS,
            'FARM_REVENUE_ONUS' => ReasonType::FARM_REVENUE_ONUS,
            'ONUS_TO_CASH' => ReasonType::ONUS_TO_CASH,
        ];
    }

}
