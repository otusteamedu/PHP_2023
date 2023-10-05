<?php

declare(strict_types=1);

namespace App\Domain\Repository;

interface Flusher
{
    public function flush(): void;
}
