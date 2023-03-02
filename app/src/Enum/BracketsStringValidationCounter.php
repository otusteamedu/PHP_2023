<?php

declare(strict_types=1);

namespace Imitronov\Hw4\Enum;

enum BracketsStringValidationCounter: string
{
    case SUCCESSFUL = 'successfulBracketsStringValidationCounter';

    case FAILED = 'failedBracketsStringValidationCounter';
}
