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
    #[Description('Chuyển từ ONUS vào ONUS Farming')]
    public const ONUS_TO_ONUS_FARMING = 4;
    #[Description('Chuyển từ ONUS Farming về ONUS')]
    public const ONUS_FARMING_TO_ONUS = 5;
    #[Description('Lãi hằng ngày ONUS')]
    public const DAILY_REVENUE_ONUS = 6;
    #[Description('Lãi tiết kiệm ONUS')]
    public const FARM_REVENUE_ONUS = 7;
    #[Description('Rút tiền ra khỏi ONUS')]
    public const ONUS_TO_CASH = 8;
    #[Description('Mua tiền mã hóa')]
    public const BUY_CRYPTO = 9;
    #[Description('Bán tiền mã hóa')]
    public const SELL_CRYPTO = 10;

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
            'ONUS_TO_ONUS_FARMING' => self::ONUS_TO_ONUS_FARMING,
            'ONUS_FARMING_TO_ONUS' => self::ONUS_FARMING_TO_ONUS,
            'DAILY_REVENUE_ONUS' => self::DAILY_REVENUE_ONUS,
            'FARM_REVENUE_ONUS' => self::FARM_REVENUE_ONUS,
            'ONUS_TO_CASH' => self::ONUS_TO_CASH,
        ];
    }

}
