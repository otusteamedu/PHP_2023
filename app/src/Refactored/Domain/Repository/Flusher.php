<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\Repository;

interface Flusher
{
    public function flush(): void;
}
