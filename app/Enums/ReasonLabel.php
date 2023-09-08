<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ReasonLabel extends Enum
{

    public const MUST_HAVE = 0;
    public const NICE_TO_HAVE = 1;
    public const WASTE = 2;

    public static function getBadge($label): string
    {
        return match ($label) {
            self::MUST_HAVE => '<h5><span class="badge bg-primary">Must Have</span></h5>',
            self::NICE_TO_HAVE => '<h5><span class="badge bg-success">Nice To Have</span></h5>',
            self::WASTE => '<h5><span class="badge bg-danger">Waste</span></h5>',
        };
    }

}
