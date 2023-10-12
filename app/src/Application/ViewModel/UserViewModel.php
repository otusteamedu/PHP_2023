<?php

declare(strict_types=1);

namespace App\Application\ViewModel;

final class UserViewModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly array $roles,
    ) {
    }
}
