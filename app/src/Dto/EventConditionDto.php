<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class EventConditionDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $key,
        #[Assert\NotBlank]
        public string $value,
    ) {
    }
}