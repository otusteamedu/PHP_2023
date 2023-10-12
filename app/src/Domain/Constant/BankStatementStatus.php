<?php

declare(strict_types=1);

namespace App\Domain\Constant;

enum BankStatementStatus: string
{
    case NEW = 'new';

    case IN_PROCESS = 'in_process';

    case WAS_SENT = 'was_sent';
}
