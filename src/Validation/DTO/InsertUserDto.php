<?php

declare(strict_types=1);

namespace Twent\Hw13\Validation\DTO;

final class InsertUserDto
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $email,
        public readonly string $password,
        public readonly ?int $age,
    ) {
    }
}
