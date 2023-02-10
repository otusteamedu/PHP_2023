<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Enums;

use Twent\BracketsValidator\Utils\EnumToArray;

enum OpeningBrackets: string
{
    use EnumToArray;

    case Default = '(';
    case Curly = '{';
    case Square = '[';
}
