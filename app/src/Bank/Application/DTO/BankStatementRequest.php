<?php

declare(strict_types=1);

namespace App\Bank\Application\DTO;

class BankStatementRequest
{
    public string $userId;
    public string $dateStart;
    public string $dateEnd;
}
