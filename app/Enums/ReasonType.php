<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

final class ReasonType extends Enum
{

    public const SPEND = 0;
    public const EARN = 1;
    public const GROUP = 2;
    #[Description('Chuyển tiền mặt vào ONUS')]
    public const CASH_TO_ONUS = 3;
    #[Description('Lãi hằng ngày ONUS')]
    public const DAILY_REVENUE_ONUS = 4;
    #[Description('Lãi tiết kiệm ONUS')]
    public const FARM_REVENUE_ONUS = 5;
    #[Description('Rút tiền ra khỏi ONUS')]
    public const ONUS_TO_CASH = 6;
    public const BUY_CRYPTO = 7;
    public const SELL_CRYPTO = 8;

    public static function getCashReasonTypes(): array
    {
        return [
            'SPEND' => self::SPEND,
            'EARN' => self::EARN,
            'GROUP' => self::GROUP,
        ];
    }

    public static function getFundExchangeReasonTypes(): array
    {
        return [
            'CASH_TO_ONUS' => self::CASH_TO_ONUS,
            'DAILY_REVENUE_ONUS' => self::DAILY_REVENUE_ONUS,
            'FARM_REVENUE_ONUS' => self::FARM_REVENUE_ONUS,
            'ONUS_TO_CASH' => self::ONUS_TO_CASH,
        ];
    }

}
