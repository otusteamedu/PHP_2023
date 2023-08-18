<?php

declare(strict_types=1);

namespace Root\App\Domain\Enum;

enum TaskStatus: string
{
    case Created = 'Created';
    case Processing = 'Processing';
    case Finished = 'Finished';
}
