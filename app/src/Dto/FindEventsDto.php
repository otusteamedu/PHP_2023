<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class FindEventsDto
{
    public function __construct(
        /** @var EventConditionDto[] */
        public array $conditions = []
    ) {
    }
}