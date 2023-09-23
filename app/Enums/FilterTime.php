<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class FilterTime extends Enum
{

    public const TODAY = 'today';
    public const THIS_WEEK = 'this-week';
    public const THIS_MONTH = 'this-month';
    public const THIS_YEAR = 'this-year';

}
