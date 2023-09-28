<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class ReasonType extends Enum
{

    public const SPEND = 0;
    public const EARN = 1;
    public const GROUP = 2;

}
