<?php

declare(strict_types=1);

namespace App\Application\ViewModel;

final class BankStatementViewModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $status,
    ) {
    }
}
