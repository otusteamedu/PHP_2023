<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase\Contract;

interface StatementGeneratorInterface
{
    public function generate(string $dateStart, string $dateEnd): string;
}
