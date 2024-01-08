<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Entity\ValueObject\ChatId;

class ProcessBankStatementCommand
{
    public function __construct(
        public readonly ChatId $chatId,
        public readonly \DateTimeInterface $dateFrom,
        public readonly \DateTimeInterface $dateTo,
    ) {
    }
}
