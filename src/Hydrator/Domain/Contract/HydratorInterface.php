<?php

declare(strict_types=1);

namespace Otus\App\Hydrator\Domain\Contract;

interface HydratorInterface
{
    public function hydrate(array $array): string;
}
