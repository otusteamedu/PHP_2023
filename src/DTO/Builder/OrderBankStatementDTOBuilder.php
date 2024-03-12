<?php
declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\OrderBankStatementDTO;
use DateTimeImmutable;
use Exception;

class OrderBankStatementDTOBuilder
{
    /**
     * @throws Exception
     */
    public function buildFromArray(array $data): OrderBankStatementDTO
    {
        $startDate = $data['startDate'] ? new DateTimeImmutable($data['startDate']) : null;
        $endDate   = $data['endDate'] ? new DateTimeImmutable($data['endDate']) : null;
        $type      = filter_var($data['type'], FILTER_VALIDATE_INT, ['options' => ['default' => null]]);
        $userId    = filter_var($data['userId'], FILTER_VALIDATE_INT, ['options' => ['default' => null]]);

        return new OrderBankStatementDTO($startDate, $endDate, $type, $userId);
    }
}
