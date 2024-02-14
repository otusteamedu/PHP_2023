<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class CreateApplicationFormRequest
{
    public function __construct(
        public readonly string $email,
        public readonly string $message
    ) {
    }
}
