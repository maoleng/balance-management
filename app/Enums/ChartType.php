<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ChartType extends Enum
{

    public const STACKED_BAR = 'stacked-bar';
    public const TREE_MAP = 'tree-map';
    public const PIE = 'pie';
    public const STACKED_AREA = 'stacked-area';

}
