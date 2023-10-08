<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\Email;

final class ProcessBankStatementCommand
{
    public function __construct(
        public readonly Email $email,
        public readonly \DateTimeInterface $dateFrom,
        public readonly \DateTimeInterface $dateTo,
    ) {
    }
}
