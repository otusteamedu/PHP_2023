<?php
declare(strict_types=1);

namespace App\DTO;

use DateTimeImmutable;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

class OrderBankStatementDTO implements JsonSerializable
{
    public function __construct(
        #[Assert\NotBlank]
        public ?DateTimeImmutable $startDate,
        #[Assert\NotBlank]
        public ?DateTimeImmutable $endDate,
        #[Assert\NotBlank]
        #[Assert\Positive]
        public ?int               $type,
        #[Assert\NotBlank]
        #[Assert\Positive]
        public ?int               $userId,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'startDate' => $this->startDate?->format('Y-m-d H:i:s'),
            'endDate'   => $this->endDate?->format('Y-m-d H:i:s'),
            'type'      => $this->type,
            'userId'    => $this->userId,
        ];
    }
}
