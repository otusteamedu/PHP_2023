<?php

declare(strict_types=1);

namespace App\Application\Dto;

use App\Entity\ValueObject\ChatId;

class BankStatementDto
{
    public ChatId $chatId;
    public \DateTimeInterface $dateFrom;
    public \DateTimeInterface $dateTo;
}
