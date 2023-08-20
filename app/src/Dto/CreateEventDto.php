<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateEventDto
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Regex('/^\d+$/')]
        public int $priority,
        /** @var EventConditionDto[] */
        #[Assert\NotBlank]
        public array $conditions,
        #[Assert\NotBlank]
        public string $title,
        #[Assert\NotBlank]
        public string $data,
    ) {
    }
}