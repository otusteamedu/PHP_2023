<?php

declare(strict_types=1);

namespace Root\App\Data;

enum TaskStatus: string
{
    case Created = 'Created';
    case Processing = 'Processing';
    case Finished = 'Finished';
}
