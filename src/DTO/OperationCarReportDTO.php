<?php
declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class OperationCarReportDTO
{
    public function __construct(
        #[Assert\NotBlank]
        private int          $operationId,
        #[Assert\NotBlank]
        #[Assert\Valid]
        private CarReportDTO $carReportDTO,
    ) {
    }

    public function getOperationId(): int
    {
        return $this->operationId;
    }

    public function getCarReportDTO(): CarReportDTO
    {
        return $this->carReportDTO;
    }
}
