<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\Repository;

interface Persister
{
    public function persist(object ...$objects): void;
}
