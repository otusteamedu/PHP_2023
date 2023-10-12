<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\Id;

final class ProcessBankStatementCommand
{
    public function __construct(
        public readonly Id $id,
        public readonly \DateTimeInterface $dateFrom,
        public readonly \DateTimeInterface $dateTo,
    ) {
    }
}
