<?php

declare(strict_types=1);

namespace App\Interfaces;

use Generator;

interface DatabaseAdapterInterface
{
    public function selectAll(string $table): Generator;
}