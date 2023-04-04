<?php

declare(strict_types=1);

namespace Twent\Hw13\Validation;

enum ValidationType: string
{
    case Insert = 'insert';
    case Default = 'default';
}
