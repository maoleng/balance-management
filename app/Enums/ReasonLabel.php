<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

final class ReasonLabel extends Enum
{

    #[Description('Chi tiêu bắt buộc')]
    public const MUST_HAVE = 0;
    #[Description('Chi tiêu linh hoạt')]
    public const NICE_TO_HAVE = 1;
    #[Description('Chi tiêu lãng phí')]
    public const WASTE = 2;

    public static function getBadge($label): string
    {
        return match ($label) {
            self::MUST_HAVE => '<div class="chip chip-outline chip-primary ms-05">&nbsp;&nbsp;Must&nbsp;&nbsp;</div>',
            self::NICE_TO_HAVE => '<div class="chip chip-outline chip-success ms-05">&nbsp;&nbsp;Nice&nbsp;&nbsp;</div>',
            self::WASTE => '<div class="chip chip-outline chip-danger ms-05">&nbsp;&nbsp;Waste&nbsp;&nbsp;</div>',
            default => '',
        };
    }

}
