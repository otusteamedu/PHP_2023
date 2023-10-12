<?php

declare(strict_types=1);

namespace App\Domain\Repository;

interface FlusherInterface
{
    public function flush(): void;
}
