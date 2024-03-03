<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Done()
 * @method static static Canceled()
 */
final class SaleStatus extends Enum
{
    const Done = 'done';
    const Canceled = 'canceled';
}
